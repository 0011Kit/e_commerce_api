<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentStatus = match ($this->order_status) {
            'D' => 'Shipping',
            'S' => 'Received',
            'R' => 'Processing Refund',
            default => 'Refunded',
        };

        return [
          'Status' => $currentStatus,
          'Grand Total' => $this->order_grand_total,
          'Order At' => $this->created_at,
          'Payment Date' => $this->payment_date->date('d-m-Y'),
          'Product Delivered Date' => $this->delivered_date,
          'Refund Date' => $this->refund_date,
          'Completed Date' => $this->completed_date,
          'Product List' 
        ];
    }
}
