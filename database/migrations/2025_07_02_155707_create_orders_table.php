<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_no');
            $table->unsignedBigInteger('customer_no');
            $table->foreign('customer_no')->references('customer_no')->on('customers')->onDelete('cascade');
            $table->string('order_status'); 
            // D = In Delivery Process, S = Delivered, R = Refund Requested, C = Completed
            $table->decimal('order_grand_total', 10, 2);
            $table->dateTime('payment_date'); 
            $table->dateTime('delivered_date')->nullable(); 
            $table->dateTime('refund_date')->nullable();
            $table->dateTime('completed_date')->nullable();
            $table->dateTime('cancel_req_date')->nullable();
            $table->dateTime('cancel_approval_date')->nullable();
            $table->string('cancel_approved_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
