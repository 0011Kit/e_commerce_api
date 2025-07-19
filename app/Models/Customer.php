<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable  implements AuthenticatableContract
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'customer_no'; // Tell Laravel to use your custom PK

    protected $keyType = 'int'; 

    //this is for mass assignment & security
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone_no',
        'customer_dob',
        'customer_password',
        'customer_address',
        'customer_state',
        'customer_balance',
        'customer_status',
        'suspected_date',
        'suspected_reason',
        'removed_date',
        'removed_reason',
        'paycmst_no'
    ];

    protected $hidden = ['customer_password'];

    protected $guarded = [];


    public function PaymentCartMst(){
        return $this->hasOne(PaymentCartMst::class , 'paycmst_no', 'paycmst_no');
    }

}
