<?php

namespace Database\Seeders;

use App\Models\Social;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
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

        // Create social accounts for some users
        foreach ($users as $user) {
            // 70% chance of having at least one social account
            if (rand(1, 100) <= 70) {
                // Each user can have 1-3 social accounts
                $socialCount = rand(1, 3);
                $usedProviders = [];
                
                for ($i = 0; $i < $socialCount; $i++) {
                    $providers = ['google', 'linkedin', 'github', 'facebook', 'twitter'];
                    $availableProviders = array_diff($providers, $usedProviders);
                    
                    if (empty($availableProviders)) {
                        break;
                    }
                    
                    $provider = $availableProviders[array_rand($availableProviders)];
                    $usedProviders[] = $provider;
                    
                    Social::factory()->create([
                        'user_id' => $user->id,
                        'provider' => $provider,
                    ]);
                }
            }
        }

        $this->command->info('Social accounts created successfully.');
    }
}