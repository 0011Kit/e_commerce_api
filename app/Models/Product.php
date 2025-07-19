<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    
    protected $primaryKey = 'product_no'; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'product_name',
        'product_unit_price',
        'product_sold_count',
        'product_stock_amt',
        'product_status',
        'product_category',
        'removed_date',
        'seller_no'
    ];    

    public function seller(){
        return $this->belongsTo(Seller::class, "seller_no","seller_no");
    }
}
