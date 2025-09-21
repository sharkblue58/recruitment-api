<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'id'   => 1,
                'name' => 'Egypt',
                'code' => 'EG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'   => 2,
                'name' => 'Saudi Arabia',
                'code' => 'SA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
