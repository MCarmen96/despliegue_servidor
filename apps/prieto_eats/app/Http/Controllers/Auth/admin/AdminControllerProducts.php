<?php

namespace App\Http\Controllers\Auth\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminControllerProducts extends Controller{
    /**
     * Muestra el listado de todos los productos (página principal del admin).
     */
    public function index()
    {
        //
        $dishes = Product::all();
        return view("admin.products.index", compact ("dishes") );
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        //
        return view("admin.products.create");
    }

    /**
     * Guarda el nuevo producto en la base de datos (aquí va la validación).
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "name"=>"required|string",
            "description"=>"required|string",
            "price"=>"required|numeric",
            "image"=>"nullable|mimes:jpg,jpeg,png"
        ]);

        $fileImage=$request->file('image');
        $rutaImage=null;

        if($fileImage){
            $rutaImage=$fileImage->store('uploads','public');
        }

        try{
            //$product=new Product($data);
            $product=new Product();
            $product->name=$request->input("name");
            $product->description=$request->input("description");
            $product->price=$request->input("price");
            $product->image=$rutaImage;
            $product->save();

            return redirect()->route("admin.products.index")->with("success","Producto creado con exito");

        }catch(\Exception $e){
            error_log($e->getMessage());

        }



        // Product::create([
        //     "name"=>$request["name"],
        //     "description"=>$request["description"],
        //     "price"=>$request["price"],
        //     "image"=>$request["image"]
        // ]);



    }

    /**
     * Muestra los detalles de un producto específico (por ejemplo, para ver fichas).
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Muestra el formulario para editar un producto ya existente.
     */
    public function edit(string $id)
    {
        //
        try{
            $product=Product::findOrFail($id);
            return view("admin.products.edit",compact("product"));
        }catch(\Exception $e){
            return back()->withErrors(['error' => 'Fallo al mostrar la ventana de edicion: ' . $e->getMessage()]);
        }

    }

    /**
     * Actualiza los datos del producto en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|string",
            "description" => "required|string",
            "price" => "required|numeric",
            "image" => "nullable|mimes:jpg,jpeg,png"
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->name = $request->input("name");
            $product->description = $request->input("description");
            $product->price = $request->input("price");

            if ($request->hasFile('image')) {
                // Guardamos la nueva imagen y actualizamos la ruta
                $rutaImage = $request->file('image')->store('uploads', 'public');
                $product->image = $rutaImage;
            }

            $product->save();

            return redirect()->route("admin.products.index")->with("exito", "Producto actualizado correctamente");

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Elimina permanentemente un producto de la base de datos.
     */
    public function destroy($id)
    {
        //
        try{
            Product::destroy($id);
            return redirect()->route("admin.products.index")->with("exito","Producto eliminado con exito");

        }catch(\Exception $e){
            return back()->with("error", "No se pudo eliminar: " . $e->getMessage());
        }

    }
}
