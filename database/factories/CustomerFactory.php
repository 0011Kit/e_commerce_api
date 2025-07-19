<?php

namespace Database\Factories;

use App\Models\PaymentCartMst;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
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
        $removed_date = null;
        $removed_reason = null;
        $suspected_date = null;
        $suspected_reason = null;
        $bool_removed = rand(1, 30) === 1;


        if($bool_removed) {
            $removed_reason = $this->faker->randomElement([
                "Other",
                "Privacy/Security Concerns",
                "No Longer Using the Platform",
                "Bad Customer Experience",
                "Too Many Notifications or Emails"
            ]);
            $removed_date = $this->faker->date('Y-m-d', now()->toDateTimeString());

        }

        $bool_suspected = rand(1, 50) === 1;
        if($bool_suspected) {
             $suspected_reason = $this->faker->randomElement([
                "Other",
                "Unusual Order Patterns",
                "Frequent Returns or Refund Requests",
                "Mismatched Shipping and Billing Info",
                "Multiple Accounts from Same Device/IP"
            ]);
            $suspected_date = $this->faker->date('Y-m-d', $removed_date); //date('formatString' , 'latest_date' ) ** latest date means the created date <= lastest_date
        }
           
        return [
            'customer_name' => $this->faker->name(),
            'customer_email'=> $this->faker->email(),
            'customer_phone_no'=> $this->faker->phoneNumber(),
            'customer_dob'=> $this->faker->date('Y-m-d', now()->subYears(18)->toDateString()),
            'customer_address'=> $this->faker->address(),
            'customer_state'=> $this->returnRandomState(),
            'customer_status'=> $bool_suspected ? "S" : ($bool_removed ? "R" : "A"),
            'customer_balance'=> $this->faker->randomFloat(2, 1, 99999999),
            'customer_password' => Hash::make('default1234'),
            'suspected_date'=> $bool_suspected? $suspected_date : null,
            'suspected_reason'=> $bool_suspected? $suspected_reason : null,
            'removed_date'=>  $bool_removed ? $removed_date : null,
            'removed_reason'=> $bool_removed ? $removed_reason : null,

        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Customer $customer) {
            $cart = \App\Models\PaymentCartMst::factory()->create([
                'customer_no' => $customer->customer_no,
            ]);

            $customer->paycmst_no = $cart->paycmst_no;
            $customer->save();
        });
    }
}
