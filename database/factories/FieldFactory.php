<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Field>
 */
class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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

        return [
            'title' => $this->faker->randomElement($fields),
            'is_system_field' => $this->faker->boolean(80), // 80% chance of being a system field
        ];
    }

    /**
     * Indicate that the field is a system field.
     */
    public function system(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_system_field' => true,
        ]);
    }

    /**
     * Indicate that the field is a custom field.
     */
    public function custom(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_system_field' => false,
        ]);
    }
}