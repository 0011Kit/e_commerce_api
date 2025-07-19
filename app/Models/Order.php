<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    
    protected $primaryKey = 'order_no';
    protected $keyType = 'int'; 

    protected $fillable = [
        'customer_no',
        'order_status',
        'order_grand_total',
        'payment_date',
        'delivered_date',
        'refund_date',
        'completed_date',
        'order_no',
    ];

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'order_no', 'order_no');
    }
}
