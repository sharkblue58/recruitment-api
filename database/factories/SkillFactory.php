<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skills = [
            // Technical Skills
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Node.js', 'Python', 'Django', 'Java', 'Spring Boot',
            'C#', '.NET', 'Ruby', 'Rails', 'Go', 'Rust', 'Swift', 'Kotlin', 'TypeScript', 'Angular',
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Elasticsearch', 'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP',
            'Git', 'GitHub', 'GitLab', 'Jenkins', 'CI/CD', 'REST API', 'GraphQL', 'Microservices', 'DevOps', 'Linux',
            
            // Soft Skills
            'Leadership', 'Team Management', 'Project Management', 'Communication', 'Problem Solving', 'Critical Thinking',
            'Time Management', 'Adaptability', 'Creativity', 'Negotiation', 'Presentation Skills', 'Mentoring',
            'Cross-functional Collaboration', 'Strategic Planning', 'Decision Making', 'Conflict Resolution',
            
            // Business Skills
            'Agile', 'Scrum', 'Kanban', 'Product Management', 'Business Analysis', 'Data Analysis', 'Market Research',
            'Customer Relations', 'Sales', 'Marketing', 'Financial Analysis', 'Risk Management', 'Quality Assurance',
            
            // Design Skills
            'UI/UX Design', 'Figma', 'Adobe Creative Suite', 'Sketch', 'Photoshop', 'Illustrator', 'InDesign',
            'Wireframing', 'Prototyping', 'User Research', 'Design Systems', 'Responsive Design',
            
            // Language Skills
            'English', 'Spanish', 'French', 'German', 'Italian', 'Portuguese', 'Chinese', 'Japanese', 'Korean', 'Arabic'
        ];

        return [
            'title' => $this->faker->randomElement($skills),
            'is_system_skill' => $this->faker->boolean(30), // 30% chance of being a system skill
        ];
    }

    /**
     * Indicate that the skill is a system skill.
     */
    public function system(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_system_skill' => true,
        ]);
    }

    /**
     * Indicate that the skill is a custom skill.
     */
    public function custom(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_system_skill' => false,
        ]);
    }
}