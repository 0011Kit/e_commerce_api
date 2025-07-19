<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentCartTrxnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'payctrxn_no' => $this->payctrxn_no,
            'seller_no'   => $this->seller_no,
            'items'       => PaymentCartDtlResource::collection($this->items)
        ];
    }
}
