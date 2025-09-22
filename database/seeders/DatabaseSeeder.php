<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CitiesTableSeeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\FieldSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CandidateSeeder;
use Database\Seeders\SkillSeeder;
use Database\Seeders\ProfessionSeeder;
use Database\Seeders\EducationSeeder;
use Database\Seeders\SocialSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');

        // Core system data (must be seeded first)
        $this->call([
            RolePermissionSeeder::class, 
            CountriesTableSeeder::class,
            CitiesTableSeeder::class,
            FieldSeeder::class,
        ]);

        $this->command->info('Core system data seeded.');

        // User and candidate data
        $this->call([
            UserSeeder::class,
            CandidateSeeder::class,
        ]);

        $this->command->info('User and candidate data seeded.');

        // Skills and related data
        $this->call([
            SkillSeeder::class,
            ProfessionSeeder::class,
            EducationSeeder::class,
            SocialSeeder::class,
        ]);

        $this->command->info('Skills and related data seeded.');
        $this->command->info('Database seeding completed successfully!');
    }
}
