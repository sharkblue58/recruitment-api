<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            // Egypt
            ['name' => 'Cairo',     'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alexandria', 'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Giza',      'country_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Saudi Arabia
            ['name' => 'Riyadh',    'country_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jeddah',    'country_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dammam',    'country_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
