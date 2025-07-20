<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelReq extends Model
{
    protected $table = 'order_cancellation_requests';
     protected $primaryKey = 'cancel_appr_no';
      protected $keyType = 'int';

     protected $fillable = [
        'order_no', 
        'seller_no', 
        'status', 
        'reason', 
        'requested_at', 
        'approved_at'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_no', 'order_no');
    }

    public function seller(){
        return $this->belongsTo(Seller::class, 'seller_no', 'seller_no');
    }
}
