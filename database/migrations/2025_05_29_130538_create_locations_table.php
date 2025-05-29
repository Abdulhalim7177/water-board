<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., 30927C, W150
            $table->string('name'); // e.g., Daura, Kusugu
            $table->enum('type', ['lga', 'ward']);
            $table->foreignId('parent_id')->nullable()->constrained('locations'); // ward -> LGA
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
?>