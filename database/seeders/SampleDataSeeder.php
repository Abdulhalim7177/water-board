<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\GeospatialData;
use App\Models\Location;
use App\Models\Tariff;
use App\Models\TariffCategory;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Locations
        Location::create(['code' => '30927C', 'name' => 'Daura', 'type' => 'lga']);
        Location::create(['code' => '30923C', 'name' => 'Batagarawa', 'type' => 'lga']);
        Location::create(['code' => 'W150', 'name' => 'Ward 150', 'type' => 'ward', 'parent_id' => 1]);
        Location::create(['code' => 'W107', 'name' => 'Ward 107', 'type' => 'ward', 'parent_id' => 2]);

        // Tariff Category
        TariffCategory::create([
            'code' => '1',
            'class' => 'A',
            'category' => 'Residential',
            'price' => 10.00,
            'admin_id' => null
        ]);

        // Existing Customer (25thMay2025...)
        $customer1 = Customer::create([
            'billing_id' => Customer::generateBillingId(),
            'delivery_code' => '2530102481',
            'household_id' => '8924',
            'first_name' => 'Abdullahi',
            'surname' => 'Adamu',
            'middle_name' => null,
            'email' => null,
            'street_name' => 'Nr.sama\'ila',
            'area' => 'Nr.sama\'ila',
            'landmark' => 'Bypass',
            'lga_code' => '30927C',
            'ward_code' => 'W150',
            'gps_coordinates' => '11.5404195 7.3025494',
            'contact' => '09087665543',
            'billing_condition' => 'Non-Metered',
            'customer_position' => 'Normally Supplied',
            'water_supply_status' => 'functional',
            'success_id' => 1,
            'status' => 'approved'
        ]);

        GeospatialData::create([
            'customer_id' => $customer1->id,
            'type' => 'area_map',
            'coordinates' => json_encode([
                ['lat' => 11.540182098577693, 'lng' => 7.302517555654049],
                ['lat' => 11.540203788471318, 'lng' => 7.3025644943118095],
                ['lat' => 11.540224474868216, 'lng' => 7.302624508738519]
            ])
        ]);

        GeospatialData::create([
            'customer_id' => $customer1->id,
            'type' => 'perimeter',
            'coordinates' => json_encode([
                ['lat' => 11.539925212710603, 'lng' => 7.302531972527504],
                ['lat' => 11.539944265634649, 'lng' => 7.302601709961892]
            ])
        ]);

        Tariff::create([
            'customer_id' => $customer1->id,
            'tariff_category_id' => 1,
            'amount' => 50.00,
            'balance' => 50.00,
            'usage_rate' => 10.00,
            'due_date' => '2025-06-25',
            'status' => 'pending'
        ]);

        // New Customer (26thMay2025...)
        $customer2 = Customer::create([
            'billing_id' => Customer::generateBillingId(),
            'delivery_code' => null,
            'household_id' => null,
            'first_name' => 'Isah',
            'surname' => 'Bala',
            'middle_name' => 'Hassan',
            'email' => null,
            'street_name' => 'Mai adua road',
            'area' => 'Tawalala',
            'landmark' => 'High court',
            'lga_code' => '30923C',
            'ward_code' => 'W107',
            'gps_coordinates' => '13.0480862 8.3216717',
            'contact' => '08065405141',
            'billing_condition' => null,
            'customer_position' => null,
            'water_supply_status' => 'functional',
            'success_id' => 1,
            'status' => 'approved'
        ]);

        GeospatialData::create([
            'customer_id' => $customer2->id,
            'type' => 'area_map',
            'coordinates' => json_encode([
                ['lat' => 13.046316943693745, 'lng' => 8.323060594466],
                ['lat' => 13.046881345772986, 'lng' => 8.323768638398],
                ['lat' => 13.0458364836721, 'lng' => 8.323682807921]
            ])
        ]);

        GeospatialData::create([
            'customer_id' => $customer2->id,
            'type' => 'perimeter',
            'coordinates' => json_encode([
                ['lat' => 13.046493646103325, 'lng' => 8.319482803344727],
                ['lat' => 13.046786298984497, 'lng' => 8.3206147655527],
                ['lat' => 13.047016240290992, 'lng' => 8.3201694464]
            ])
        ]);

        // Existing Customer (Sample 2.xlsx)
        $customer3 = Customer::create([
            'billing_id' => Customer::generateBillingId(),
            'delivery_code' => null,
            'household_id' => null,
            'first_name' => 'Haruna',
            'surname' => 'Haruna',
            'middle_name' => null,
            'email' => 'harunaharuna@gmail.com',
            'street_name' => 'Muhammad bahari street',
            'area' => 'Kusugu',
            'landmark' => 'Daura edi',
            'lga_code' => '30927C',
            'ward_code' => null,
            'gps_coordinates' => '12.9411824 7.600095',
            'contact' => '08061641267',
            'billing_condition' => null,
            'customer_position' => null,
            'water_supply_status' => 'functional',
            'success_id' => 1,
            'status' => 'approved'
        ]);

        // New Customer (Sample.xlsx)
        $customer4 = Customer::create([
            'billing_id' => Customer::generateBillingId(),
            'delivery_code' => null,
            'household_id' => null,
            'first_name' => 'Ibrahim',
            'surname' => 'Abdurahman',
            'middle_name' => null,
            'email' => null,
            'street_name' => 'Ajiwa',
            'area' => 'Ajiwa',
            'landmark' => 'Ajiwa',
            'lga_code' => '30923C',
            'ward_code' => null,
            'gps_coordinates' => '12.9501557 7.700908',
            'contact' => '07080170007',
            'billing_condition' => null,
            'customer_position' => null,
            'water_supply_status' => 'functional',
            'success_id' => 1,
            'status' => 'approved'
        ]);
    }
}
?>