<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Seeder;


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
                'password' => 'password', // هيتهشّ تلقائي
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'Software Engineering')->first()?->id ?? $fields->random()->id,
                'role' => 'candidate',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1234567891',
                'password' => 'password',
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'Data Science')->first()?->id ?? $fields->random()->id,
                'role' => 'recruiter',
            ],
            [
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '+1234567892',
                'password' => 'password',
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'UI/UX Design')->first()?->id ?? $fields->random()->id,
                'role' => 'candidate',
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'email' => 'sarah.wilson@example.com',
                'phone' => '+1234567893',
                'password' => 'password',
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'Product Management')->first()?->id ?? $fields->random()->id,
                'role' => 'recruiter',
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.brown@example.com',
                'phone' => '+1234567894',
                'password' => 'password',
                'is_term_accepted' => true,
                'field_id' => $fields->where('title', 'DevOps')->first()?->id ?? $fields->random()->id,
                'role' => 'candidate',
            ],
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);

            $user = User::create($userData);

            // Assign role (by name not ID, Spatie uses role names internally)
            $user->assignRole($role);
        }

        // Create additional random users (default to candidate for example)
        User::factory(15)->create([
            'field_id' => $fields->random()->id,
        ])->each(function ($user) {
            $user->assignRole('candidate');
        });

        $this->command->info('Users seeded successfully.');
    }
}
