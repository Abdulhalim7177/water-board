<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreignId('tariff_category_id')->constrained();
            $table->decimal('amount', 8, 2);
            $table->decimal('balance', 8, 2)->default(0);
            $table->decimal('usage_rate', 8, 2);
            $table->date('due_date');
            $table->enum('status', ['pending', 'partially_paid', 'paid'])->default('pending');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};