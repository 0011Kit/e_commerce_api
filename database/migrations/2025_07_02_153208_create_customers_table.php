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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_no');
            $table->timestamps();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone_no');
            $table->date('customer_dob');
            $table->string('customer_password');
            $table->text('customer_address');
            $table->double('customer_balance');
            $table->string('customer_status'); // A - Active; R - Removed; S - Suspected
            $table->string('customer_state');
            $table->dateTime('suspected_date')->nullable();
            $table->string('suspected_reason')->nullable();
            $table->dateTime('removed_date')->nullable();
            $table->string('removed_reason')->nullable();

            $table->integer('paycmst_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
