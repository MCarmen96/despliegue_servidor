<?php

namespace App\Http\Controllers\Auth\admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminControllerOffers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $offers= Offer::with('productsOffer.product')->get();
        //dd($offers);
        return view("admin.offers.index", compact ("offers") );

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $dishes = Product::all();
        return view("admin.offers.create",compact("dishes"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated=$request->validate([
            'date_delivery'=>'required|date_format:Y-m-d|after:today',
            'time_delivery'=>'required|string|max:255',
            'dish_selected'=>'required|array|min:1',
            'dish_selected.*'=>'integer|distinct|exists:products,id'//El asterisco (*) le dice a Laravel: "Aplica estas reglas a cada uno de los elementos que hay dentro del array".

        ],[ /* mensajes personalizados */]);// mensajes personalizados=>'campo.regla' => 'Mensaje'

        try{
            DB::transaction(function() use ($validated){

                /*COMO AQUI YA ESTO CREANDO LA OFERTA LOS ID PRODUCTS PERTENECEN A ESTA OFERTA */
                $offer=Offer::create([
                    'date_delivery'=>$validated['date_delivery'],
                    'time_delivery'=>$validated['time_delivery']
                ]);


                //obtener un array con los ids de los productos incluidos en la oferta
                $productIds = $validated['dish_selected'];

                //convertimos una lista de IDs de productos en una colección que contiene un array asociativo con los ids
                    $rows = collect($productIds)->map(fn($id) => [
                        'product_id' => $id,

                    ])->values()->all();

                    // Insertar todos los productos en la tabla intermedia de golpe
                    // productsOffer() es la relación HasMany hacia el modelo intermedio
                    $offer->productsOffer()->createMany($rows);//El método createMany está diseñado para insertar múltiples filas de una sola vez.
                    //INSERTARA  UNA FILA POR CADA PRODUCTO QUE SE HA SELECIONADO PARA CREAR LA  OFERTA
            });


            return redirect()->route("admin.offers.index")->with('success','Oferta guardada');

        }catch(\Exception $e){

            return back()->withErrors(['error' => 'Fallo al crear oferta: ' . $e->getMessage()]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try{
            $offer=Offer::find($id);
            $dishes = Product::all();
            return view("admin.offers.edit", compact ("offer","dishes") );
        }catch(\Exception $e){
            return back()->withErrors(['error' => 'Fallo al editar la oferta: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{

            $offer=Offer::findOrFail($id);
            $offer->delete();
            return redirect()->route("admin.offers.index")->with('success','Oferta Eliminada');

        }catch(\Exception $e){
                return back()->withErrors(['error' => 'Fallo al eliminar oferta: ' . $e->getMessage()]);
        }
    }
}
