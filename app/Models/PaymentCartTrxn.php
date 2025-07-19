<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentCartDtl;
use App\Models\PaymentCartMst;
use App\Models\Seller;

class PaymentCartTrxn extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentCartTrxnFactory> */
    use HasFactory;
    
    protected $primaryKey = 'payctrxn_no'; 
    protected $keyType = 'int'; 
    
    protected $fillable = [
        'paycmst_no',      
        'seller_no'        
    ];

    public function cart(){
        return $this->belongsTo(PaymentCartMst::class, "paycmst_no","paycmst_no");
    }

    public function items(){
        return $this->hasMany(PaymentCartDtl::class, 'payctrxn_no', 'payctrxn_no');
    }

    public function seller(){
        return $this->belongsTo(Seller::class, 'seller_no', 'seller_no'); 
    }
}
