<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentCartDtlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->product;

        return [
            'paycdtl_no'           => $this->paycdtl_no,
            'paycdtl_selected_amt' => $this->paycdtl_selected_amt,
            'total_amt'            => $this->paycdtl_selected_amt * $product->product_unit_price,
            'product_no'           => $product->product_no,
            'product'              => [
                'product_no'          => $product->product_no,
                'product_name'        => $product->product_name,
                'product_unit_price'  => $product->product_unit_price,
                'product_category'    => $product->product_category,
            ],
        ];
    }
}
