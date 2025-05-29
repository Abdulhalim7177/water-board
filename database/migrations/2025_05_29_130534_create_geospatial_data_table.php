<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('geospatial_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->enum('type', ['area_map', 'perimeter']);
            $table->text('coordinates'); // JSON, e.g., [{"lat":"11.540182","lng":"7.302517"},...]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geospatial_data');
    }
};
?>