<?php

namespace App\Filters\V1;

use App\Filters\GeneralFilter;
use Illuminate\Http\Request;

class ProductFilter extends GeneralFilter{
     protected $safeParams =[        
        'name',
        'unitPrice',
        'soldCount',
        'stockAmt',
        'status',
        'category',
        'sellerNo'
    ];

     protected $columnMap =[    
        'name' => 'product_name',
        'unitPrice' => 'product_unit_price', 
        'soldCount' => 'product_sold_count',
        'stockAmt' => 'product_stock_amt', 
        'status' => 'product_status',
        'category' => 'product_category',
        'removedDate' => 'removed_date',
        'sellerNo' => 'seller_no'
    ];

}