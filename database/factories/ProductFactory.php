<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seller;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = rand(1,30) === 1 ? "R" : (rand(1,20) === 1 ? "S" : "A");
        $stock_amt = $status=="A" ? $this->faker->numberBetween(10, 100): 0 ; 
        $category = [
            'Electronics',
            'Fashion',
            'Home & Living',
            'Health & Beauty',
            'Groceries & Essentials',
            'Sports & Outdoors',
            'Tools & DIY',
            'Office & Stationery',
            'Pets & Garderning'
        ];
        
        return [
            'product_name' => ucfirst($this->faker->words(2, true)), //random 2 words
            'product_unit_price'=> $this->faker->randomFloat(2, 1, 300),
            'product_sold_count'=> $this->faker->numberBetween(1,999),
            'product_stock_amt'=> $stock_amt,
            'product_status'=> $status,
            'product_category'=>$this->faker->randomElement($category),
            'removed_date'=> $status == "R" ? $this->faker->date('Y-m-d') : null,
            'seller_no'=> null
        ];
    }
}
