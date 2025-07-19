<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\SellerFactory> */
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $primaryKey = 'seller_no'; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'seller_name',
        'seller_email',
        'seller_password',
        'seller_phone_no',
        'seller_location',
        'seller_status',
        'suspected_date',
        'removed_date'
    ];

    public function product(){
        return $this->hasMany(Product::class, "product_no","product_no");
    }
}
