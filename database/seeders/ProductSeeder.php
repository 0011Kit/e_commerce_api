<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seller;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $sellers = Seller::factory()->count(5)->create();

        foreach ($sellers as $seller) {
            // create 3-6 products for each seller
            Product::factory()
                ->count(rand(3, 6))
                ->create(['seller_no' => $seller->seller_no]);
        }
    }
}
