<?php

namespace App\Filters\V1;

use App\Filters\GeneralFilter;
use Illuminate\Http\Request;


class OrderFilter extends GeneralFilter{
    protected $safeParams =[
           'status',  
           'paymentDate',
           'deliveredDate',
           'refundDate',
           'completedDate'
    ];

    protected $columnMap =[
           'status' =>'order_status',  
           'paymentDate' =>'payment_date',
           'deliveredDate' =>'delivered_date',
           'refundDate' =>'refund_date',
           'completedDate' =>'completed_date'
    ];
 
}