<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product; // Aunque no se use directamente, lo dejamos por si acaso
use App\Models\ProductOffer;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Muestra el carrito
    public function index()
    {
        // Recuperamos el carrito de la sesión, si no existe devolvemos un array vacío
        $carrito = session('cart', []);

        // Obtenemos los IDs de las ofertas (claves del primer nivel del array)
        $offerIds = array_keys($carrito);

        $productOfferId = [];
        // Recorremos el carrito para sacar los IDs de los productos de cada oferta
        foreach ($carrito as $offerId => $items) {
           if(is_array($items)){
                $productOfferId = array_merge($productOfferId, array_keys($items));
           }
        }

        // Eliminamos IDs duplicados por seguridad
        $productOfferId = array_unique($productOfferId);

        // Buscamos las ofertas en la base de datos
        $offersById = Offer::whereIn("id", $offerIds)
            ->get()
            ->keyBy("id");

        // Buscamos los productos-oferta con su producto relacionado
        $productsOffersById = ProductOffer::with("product")
            ->whereIn("id", $productOfferId)
            ->get()
            ->keyBy("id");

        // Retornamos la vista pasando las variables necesarias
        // Usamos 'cart' para la vista porque es lo que espera el blade actual, aunque aquí lo llamemos $carrito
        return view('cart.index', [
            'cart' => $carrito,
            'offersById' => $offersById,
            'productOffersById' => $productsOffersById // Ojo al nombre que espera la vista
        ]);
    }

    // Añade un producto al carrito
    public function add(Request $request, $id)
    {
        // $id es el product_offer_id
        $carrito = session()->get('cart', []);

        // 1. Obtenemos la relación producto-oferta para saber a qué oferta pertenece
        $productOffer = ProductOffer::with('product')->findOrFail($id);
        $offerId = $productOffer->offer_id;
        $productName = $productOffer->product->name;

        // 2. Aseguramos que el índice de la oferta exista en el carrito
        if (!isset($carrito[$offerId])) {
            $carrito[$offerId] = [];
        }

        // 3. Añadimos o incrementamos el producto específico de esa oferta
        if (isset($carrito[$offerId][$id])) {
            $carrito[$offerId][$id]++;
        } else {
            $carrito[$offerId][$id] = 1;
        }

        // 4. Guardamos en sesión y enviamos mensaje de éxito
        session()->put('cart', $carrito);
        
        return redirect()->back()->with('success', "✓ {$productName} añadido correctamente");
    }

    // Elimina un producto del carrito
    public function remove($id)
    {
        $carrito = session()->get('cart', []);
        
        // Buscamos el producto-oferta para saber cual es su oferta padre
        $productOffer = ProductOffer::findOrFail($id);
        $offerId = $productOffer->offer_id;

        // Verificamos si existe esa oferta y ese producto en el carrito
        if (isset($carrito[$offerId])) {
            if (isset($carrito[$offerId][$id])) {
                unset($carrito[$offerId][$id]); // Lo borramos
            }

            // Si la oferta se queda vacía sin productos, borramos la oferta del carrito también
            if (count($carrito[$offerId]) === 0) {
                unset($carrito[$offerId]);
            }
        }

        session()->put('cart', $carrito);

        return redirect()->route('cart.index')->with('success', 'Producto eliminado');
    }

    // Vacía todo el carrito
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado');
    }

    // Incrementa la cantidad de un producto (botón +)
    public function increase($id)
    {
        $carrito = session()->get('cart', []);
        $productOffer = ProductOffer::findOrFail($id);
        $offerId = $productOffer->offer_id;

        if (isset($carrito[$offerId])) {
            if (isset($carrito[$offerId][$id])) {
                $carrito[$offerId][$id]++;
            }
        }

        session()->put('cart', $carrito);
        return redirect()->route('cart.index');
    }

    // Decrementa la cantidad de un producto (botón -)
    public function decrease($id)
    {
        $carrito = session()->get('cart', []);
        $productOffer = ProductOffer::findOrFail($id);
        $offerId = $productOffer->offer_id;

        if (isset($carrito[$offerId])) {
            if (isset($carrito[$offerId][$id])) {
                if ($carrito[$offerId][$id] > 1) {
                    $carrito[$offerId][$id]--;
                } else {
                    // Si llega a 0 o 1 y restamos, lo quitamos (opcional, o dejarlo en 1)
                     // Pero normalmente decrementar en 1 no borra, solo baja hasta 1.
                     // Si quieres que al bajar de 1 se borre, usa la lógica de remove.
                     // Aquí dejaremos que baje hasta 1.
                }
            }
        }

        session()->put('cart', $carrito);
        return redirect()->route('cart.index');
    }

    // Procesa el pedido
    public function order()
    {
        $carrito = session('cart', []);
        
        if (empty($carrito)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío');
        }

        $total = 0;
        
        // Creamos el pedido inicial con total 0
        $order = Order::create([
            "user_id" => Auth::id(),
            "total" => 0
        ]);

        foreach ($carrito as $offerId => $productos) {
            foreach ($productos as $productOfferId => $cantidad) {
                
                // Buscamos el producto en BD para saber el precio real
                $productOffer = ProductOffer::with('product')->find($productOfferId);
                
                if($productOffer && $productOffer->product) {
                    $producto = $productOffer->product;
                    $total += $producto->price * $cantidad;

                    // Creamos la línea del pedido
                    // OJO: La tabla 'product_orders' usa 'product_id' que relaciona con 'product_offers'
                    ProductOrder::create([
                        "order_id" => $order->id,
                        "product_id" => $productOffer->id, // ID de la tabla product_offers
                        "quantity" => $cantidad
                    ]);
                }
            }
        }

        // Actualizamos el total del pedido
        $order->total = $total;
        $order->save();

        // Vaciamos el carrito
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Pedido realizado con éxito!');
    }
    
    // Método para ver el historial de pedidos
    public function orders()
    {
        // Busca pedidos del usuario logueado
        // Ordenamos por fecha descendente (latest)
        $orders = Order::where('user_id', Auth::id())
                      ->latest() 
                      ->get();
                      
        return view('cart.orders', compact('orders'));
    }


}

  
