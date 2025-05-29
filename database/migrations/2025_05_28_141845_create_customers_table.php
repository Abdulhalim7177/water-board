<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('billing_id', 8)->unique(); // e.g., 25050001
            $table->string('delivery_code')->nullable(); // e.g., 2530102481
            $table->string('household_id')->nullable()->unique(); // e.g., 8924
            $table->string('first_name'); // e.g., Abdullahi
            $table->string('surname'); // e.g., Adamu
            $table->string('middle_name')->nullable(); // e.g., Hassan
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->text('street_name');
            $table->string('area')->nullable(); // e.g., Tawalala
            $table->string('landmark')->nullable(); // e.g., Bypass
            $table->string('lga_code')->nullable(); // e.g., 30927C
            $table->string('ward_code')->nullable(); // e.g., W150
            $table->string('gps_coordinates')->nullable(); // e.g., "11.5404195 7.3025494"
            $table->string('contact');
            $table->string('billing_condition')->nullable(); // e.g., Non-Metered
            $table->string('customer_position')->nullable(); // e.g., Normally Supplied
            $table->string('water_supply_status')->default('functional');
            $table->foreignId('success_id')->constrained('successes');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
?>