<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Name' => $this->seller_name,
            'Email' => $this->seller_email,
            'Contact Number' => $this->seller_phone_no,
            'State' => $this->seller_location,
            'Join At' => $this->created_at->format('d-m-Y')
        ];
    }
}
