<?php

namespace Database\Factories;

use App\Models\PaymentCartMst;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seller;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentCartTrxn>
 */
class PaymentCartTrxnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'paycmst_no' => PaymentCartMst::factory(),
            'seller_no' => Seller::factory()
        ];
    }
}
