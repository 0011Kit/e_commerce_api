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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id('seller_no');
            $table->timestamps();
            $table->string('seller_name');
            $table->string('seller_email');
            $table->string('seller_password');
            $table->string('seller_phone_no');
            $table->text('seller_location');
            $table->string('seller_status'); // A - Active; R - Removed; S - Suspected
            $table->dateTime('suspected_date')->nullable();
            $table->dateTime('removed_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
