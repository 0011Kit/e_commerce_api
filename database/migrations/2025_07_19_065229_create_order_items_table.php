<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_items_no');
            $table->timestamps();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);

            // FK to orders table
            $table->unsignedBigInteger('order_no');
            $table->foreign('order_no')->references('order_no')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('product_no');
            $table->foreign('product_no')->references('product_no')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
