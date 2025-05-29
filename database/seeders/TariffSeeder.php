<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Tariff;
use App\Models\TariffCategory;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    public function run(): void
    {
        $customer = Customer::first();
        if (!$customer) {
            $customer = Customer::create([
                'billing_id' => Customer::generateBillingId(),
                'delivery_code' => null,
                'first_name' => 'John',
                'surname' => 'Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password123'),
                'street_name' => '123 Street',
                'contact' => '1234567890',
                'success_id' => 1,
                'status' => 'approved',
                'water_supply_status' => 'functional',
            ]);
        }

        $category = TariffCategory::first();
        if (!$category) {
            $category = TariffCategory::create([
                'code' => 'cat1',
                'class' => 'A',
                'category' => 'Residential',
                'price' => 10.00,
                'admin_id' => null,
            ]);
        }

        Tariff::create([
            'customer_id' => $customer->id,
            'tariff_category_id' => $category->id,
            'amount' => 100.00,
            'balance' => 100.00,
            'usage_rate' => 10.00,
            'due_date' => '2025-06-28',
            'status' => 'pending',
        ]);
    }
}
?>