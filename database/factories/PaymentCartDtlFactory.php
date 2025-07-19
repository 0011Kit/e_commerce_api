<?php

namespace Database\Factories;

use App\Models\PaymentCartTrxn;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentCartDtl>
 */
class PaymentCartDtlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'paycdtl_selected_amt' => $this->faker->numberBetween(1,20),
            'product_no' => Product::factory(),
            'payctrxn_no' => PaymentCartTrxn::factory(),

        ];
    }
}
