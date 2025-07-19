<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Customer No' => $this->customer_no, 
            'Name' => $this->customer_name,
            'Email' => $this->customer_email,
            'Contact No' => $this->customer_phone_no,
            'Day Of Birth' => $this->customer_dob,     
            'State' => $this->customer_state,      
            'Join at' => $this->created_at->format('d-m-Y')

        ];
    }
}
