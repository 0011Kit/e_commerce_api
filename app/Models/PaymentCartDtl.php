<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class PaymentCartDtl extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentCartDtlFactory> */
    use HasFactory;

    
    protected $primaryKey = 'paycdtl_no'; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'payctrxn_no',              
        'product_no',               
        'paycdtl_selected_amt'           
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_no', 'product_no');
    }
}
