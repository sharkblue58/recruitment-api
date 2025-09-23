<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profession>
 */
class ProfessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jobTitles = [
            'Software Engineer', 'Senior Software Engineer', 'Lead Developer', 'Full Stack Developer',
            'Frontend Developer', 'Backend Developer', 'DevOps Engineer', 'Data Scientist', 'Data Analyst',
            'Product Manager', 'Project Manager', 'Scrum Master', 'UX Designer', 'UI Designer', 'Graphic Designer',
            'Marketing Manager', 'Sales Manager', 'Business Analyst', 'Quality Assurance Engineer', 'System Administrator',
            'Database Administrator', 'Network Engineer', 'Security Engineer', 'Mobile Developer', 'iOS Developer',
            'Android Developer', 'Machine Learning Engineer', 'Cloud Engineer', 'Solutions Architect', 'Technical Lead'
        ];

        $companies = [
            'Google', 'Microsoft', 'Apple', 'Amazon', 'Meta', 'Netflix', 'Uber', 'Airbnb', 'Spotify', 'Slack',
            'Shopify', 'Stripe', 'Square', 'PayPal', 'Twitter', 'LinkedIn', 'GitHub', 'Atlassian', 'Salesforce',
            'Adobe', 'Oracle', 'IBM', 'Intel', 'NVIDIA', 'Tesla', 'SpaceX', 'OpenAI', 'Anthropic', 'Hugging Face',
            'TechCorp', 'InnovateLabs', 'Digital Solutions', 'CloudTech', 'DataFlow', 'WebCraft', 'AppWorks',
            'CodeForge', 'DevStudio', 'TechStart', 'FutureSoft', 'NextGen', 'ProTech', 'SmartSys', 'CyberSoft'
        ];

        $startDate = $this->faker->dateTimeBetween('-10 years', '-1 year');
        $endDate = $this->faker->optional(0.7)->dateTimeBetween($startDate, 'now');

        return [
            'job_title' => $this->faker->randomElement($jobTitles),
            'company_name' => $this->faker->randomElement($companies),
            'city_id' => City::factory(),
            'start' => $startDate,
            'end' => $endDate,
            'description' => $this->faker->optional(0.8)->paragraphs(2, true),
            'candidate_id' => Candidate::factory(),
        ];
    }

    /**
     * Indicate that the profession is current (no end date).
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'end' => null,
        ]);
    }

    /**
     * Indicate that the profession is in a specific city.
     */
    public function inCity(City $city): static
    {
        return $this->state(fn (array $attributes) => [
            'city_id' => $city->id,
        ]);
    }
}