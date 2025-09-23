<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all fields
        $fields = Field::all();
        
        if ($fields->isEmpty()) {
            $this->command->warn('No fields found. Please run FieldSeeder first.');
            return;
        }

        // Create some test users
        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1234567890',
                'password' => Hash::make('password'),
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'Software Engineering')->first()?->id ?? $fields->random()->id,
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1234567891',
                'password' => Hash::make('password'),
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'Data Science')->first()?->id ?? $fields->random()->id,
            ],
            [
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '+1234567892',
                'password' => Hash::make('password'),
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'UI/UX Design')->first()?->id ?? $fields->random()->id,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'email' => 'sarah.wilson@example.com',
                'phone' => '+1234567893',
                'password' => Hash::make('password'),
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'Product Management')->first()?->id ?? $fields->random()->id,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.brown@example.com',
                'phone' => '+1234567894',
                'password' => Hash::make('password'),
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'DevOps')->first()?->id ?? $fields->random()->id,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create additional random users
        User::factory(15)->create([
            'field_id' => $fields->random()->id,
        ]);

        $this->command->info('Users seeded successfully.');
    }
}