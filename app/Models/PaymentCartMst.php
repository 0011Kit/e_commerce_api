<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentCartTrxn;

class PaymentCartMst extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentCartMstFactory> */
    use HasFactory;

    protected $primaryKey = 'paycmst_no'; 
    protected $keyType = 'int'; 

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_no', 'customer_no');
    }

    public function transactions(){
        return $this->hasMany(PaymentCartTrxn::class, 'paycmst_no', 'paycmst_no');
    }
}
