<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Helpers\CommonFunction;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private function returnRandomState()
    {
        $stateList = 
        [           
            "Johor",
            "Kedah",
            "Kelantan",
            "Melaka",
            "Negeri Sembilan",
            "Pahang",
            "Penang",
            "Perak",
            "Perlis",
            "Sabah",
            "Sarawak",
            "Selangor",
            "Terengganu",
            "Kuala Lumpur",
            "Putrajaya",
            "Labuan"
        ];

        return $stateList[array_rand($stateList)];         
    }
   
    public function definition(): array
    {
        return [
            'seller_name' => $this->faker->name(),
            'seller_email'=> $this->faker->email(),
            'seller_phone_no'=> $this->faker->phoneNumber(),
            'seller_location'=> $this->returnRandomState(),            
            'seller_password' => Hash::make('default1234'),
            'seller_status'=> "A",
            'suspected_date'=> null,
            'removed_date'=> null
        ];
    }

}
