<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TariffSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tariff_categories')->insert([
            'class' => 'A',
            'category' => 'Residential',
            'price' => 10.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tariffs')->insert([
            'customer_id' => 1, // Assumes customer with id=1 exists
            'tariff_category_id' => 1,
            'amount' => 100.00,
            'balance' => 100.00,
            'usage_rate' => 10.00,
            'due_date' => '2025-06-28',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
?>