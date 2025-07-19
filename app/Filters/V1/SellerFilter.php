<?php

namespace App\Filters\V1;

use App\Filters\GeneralFilter;

class SellerFilter extends GeneralFilter{    
    protected $safeParams =[
        'name',
        'email',
        'phone',
        'location',
        'status'
    ];

     protected $columnMap =[
        'name' => 'seller_name',
        'email' => 'seller_email',
        'phone' => 'seller_phone_no',
        'location' => 'seller_location',
        'status' => 'seller_status'
    ];


}