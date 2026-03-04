<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación con el producto-oferta
    // Especificamos 'product_id' porque es el nombre de la columna en la tabla product_orders
    public function productOffer()
    {
        return $this->belongsTo(ProductOffer::class, 'product_id');
    }
}
