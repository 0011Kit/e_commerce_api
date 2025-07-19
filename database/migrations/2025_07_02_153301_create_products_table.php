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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_no');
            $table->timestamps();
            $table->string('product_name');
            $table->decimal('product_unit_price', 10, 2);
            $table->integer('product_sold_count');
            $table->integer('product_stock_amt');
            $table->string('product_status'); // A - Active; R - Removed; S - Sold Out
            $table->string('product_category'); 
            $table->dateTime('removed_date')->nullable();
            $table->integer('seller_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
