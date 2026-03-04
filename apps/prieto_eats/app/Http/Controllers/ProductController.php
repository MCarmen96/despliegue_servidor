<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Offer;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //class ProductController extends Controller

    public function home()
    {

        //$menus = Product::where("product_type", "menu")->get();

        $offersByDate= Offer::with('productsOffer.product')->get()->groupBy('date_delivery');

  /*       [
    "2026-01-27" => [  // Esto es $date
        {id: 1, name: "Oferta Lunes", ...}, // Estas son las $offers
        {id: 2, name: "Oferta especial", ...}
    ],
    "2026-01-29" => [  // Siguiente vuelta del bucle, nueva $date
        {id: 3, name: "Oferta Jueves", ...}  // Nuevas $offers
    ]
]
 */
        return view("home", compact ("offersByDate") );
    }

}
