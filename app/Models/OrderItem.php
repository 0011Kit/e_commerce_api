<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'order_items_no';
    protected $keyType = 'int'; 

    protected $fillable = [
        'order_no',
        'product_no',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_no', 'product_no');
    }
}
