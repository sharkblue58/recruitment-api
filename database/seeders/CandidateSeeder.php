<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        // Get all cities
        $cities = City::all();
        
        if ($cities->isEmpty()) {
            $this->command->warn('No cities found. Please run CitiesTableSeeder first.');
            return;
        }

        // Create candidates for 70% of users
        $candidateCount = (int) ($users->count() * 0.7);
        $selectedUsers = $users->random($candidateCount);

        foreach ($selectedUsers as $user) {
            Candidate::create([
                'user_id' => $user->id,
                'city_id' => $cities->random()->id,
            ]);
        }

        $this->command->info('Candidates seeded successfully.');
    }
}