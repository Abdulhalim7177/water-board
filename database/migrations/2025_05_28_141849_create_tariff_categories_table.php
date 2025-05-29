<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tariff_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., 1, cat1
            $table->string('class'); // e.g., A
            $table->string('category'); // e.g., Residential
            $table->decimal('price', 8, 2); // e.g., 10.00
            $table->foreignId('admin_id')->nullable()->constrained('admins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariff_categories');
    }
};
?>