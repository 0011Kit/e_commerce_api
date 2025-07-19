<?php

namespace App\Filters\V1;

use App\Filters\GeneralFilter;
use Illuminate\Http\Request;


class CustomerFilter extends GeneralFilter{
    protected $safeParams  = [ 
        'name',
        'email',
        'phone',
        'state',
        'status',
        'dob'
    ];

     protected $columnMap =[
        'name' => 'customer_name',
        'email' => 'customer_email',
        'phone' => 'customer_phone_no',
        'state' => 'customer_state',
        'status' => 'customer_status',
        'dob' => 'customer_dob'
    ];


   
}

