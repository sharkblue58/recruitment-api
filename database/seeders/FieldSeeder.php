<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            'Computer Science',
            'Software Engineering',
            'Information Technology',
            'Data Science',
            'Cybersecurity',
            'Artificial Intelligence',
            'Machine Learning',
            'Web Development',
            'Mobile Development',
            'Game Development',
            'DevOps',
            'Cloud Computing',
            'Database Administration',
            'Network Engineering',
            'System Administration',
            'UI/UX Design',
            'Graphic Design',
            'Digital Marketing',
            'Business Analysis',
            'Project Management',
            'Product Management',
            'Quality Assurance',
            'Technical Writing',
            'Sales Engineering',
            'Customer Success',
            'Human Resources',
            'Finance',
            'Accounting',
            'Marketing',
            'Sales',
            'Operations',
            'Consulting',
            'Research & Development',
            'Education',
            'Healthcare Technology',
            'Fintech',
            'E-commerce',
            'Blockchain',
            'IoT (Internet of Things)',
            'Robotics',
            'Bioinformatics',
            'Environmental Technology',
            'Automotive Technology',
            'Aerospace Technology',
            'Telecommunications',
            'Media & Entertainment',
            'Gaming',
            'Sports Technology',
            'Real Estate Technology',
            'Legal Technology'
        ];

        foreach ($fields as $field) {
            Field::create([
                'title' => $field,
                'is_system_field' => true,
            ]);
        }

        $this->command->info('Fields seeded successfully.');
    }
}