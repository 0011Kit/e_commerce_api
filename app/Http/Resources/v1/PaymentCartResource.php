<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'paycmst_no'   => $this->paycmst_no,
            'customer_no'  => $this->customer_no,
            'transactions' => PaymentCartTrxnResource::collection($this->transactions)
        ];
    }
}
