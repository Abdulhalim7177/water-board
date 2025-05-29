<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeographicalSeeder extends Seeder
{
    public function run(): void
    {
        $districtId = DB::table('districts')->insertGetId([
            'name' => 'Central District',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $zoneId = DB::table('zones')->insertGetId([
            'district_id' => $districtId,
            'name' => 'Zone 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $subzoneId = DB::table('subzones')->insertGetId([
            'zone_id' => $zoneId,
            'name' => 'Subzone 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $roadId = DB::table('roads')->insertGetId([
            'subzone_id' => $subzoneId,
            'name' => 'Main Road',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $polioId = DB::table('polios')->insertGetId([
            'road_id' => $roadId,
            'name' => 'Polio 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Success::create(['name' => 'GeoZone1']);

        DB::table('successes')->insert([
            'polio_id' => $polioId,
            'name' => 'Success 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}