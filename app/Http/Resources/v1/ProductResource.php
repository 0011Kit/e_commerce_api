<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [           
        'Product Id' =>$this->product_no,
        'Product Name' =>$this->product_name,
        'Price' =>$this->product_unit_price,
        'Category' =>$this->product_category,
        'Sold Count' => $this->product_sold_count,
        'Available Amount' => $this->product_sold_count,
        'Seller No' => $this->seller_no
        ];
    }
}
