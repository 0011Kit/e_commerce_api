<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $status = $this->faker->randomElement(['D','S','R','C']);
        $payment_date = Carbon::today()->toDateTimeString();

        $refund_reason = [
            "Item Not Received",
            "Wrong Item Delivered",
            "Item Damaged or Defective",
            "Update Order Detail"
        ];  

        if($refund_reason == "Item Not Received"){
            $bool_notReceivedItem = true; 
            $delivered_date = null; 
        }else{
            $delivered_date = Carbon::parse($payment_date)->addDays(rand(3,7))->toDateTimeString(); 
        }
          
        $refund_date = Carbon::parse($delivered_date)->addDays(rand(0,3))->toDateTimeString(); 
        $completed_date = Carbon::parse($refund_date)->addDays(rand(2,6))->toDateTimeString();

        $bool_deliverDate = false; 
        $bool_refundDate = false;
        $bool_completedDate = false;


        switch($status){
            case 'S':
                $bool_deliverDate = true;
                break;
            case 'R':
                $bool_deliverDate = (!$bool_notReceivedItem) ? true : false;
                $bool_refundDate = true;
                break;
            case 'C':
                $bool_deliverDate = true; 
                $bool_refundDate = true;
                $bool_completedDate = true;
                break;  
        }

        return [
            'order_status' => $status,
            'order_grand_total' => "",
            'payment_date' => $payment_date, 
            'delivered_date' => $bool_deliverDate ? $delivered_date : null, 
            'refund_date' => $bool_refundDate ? $refund_date : null ,     
            'refund_reason' =>  $bool_refundDate ? $refund_reason : null,      
            'completed_date' => $bool_completedDate ? $completed_date :  null
        ];
    }
}
