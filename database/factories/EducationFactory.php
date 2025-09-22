<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $colleges = [
            'Harvard University', 'Stanford University', 'MIT', 'University of California, Berkeley', 'Carnegie Mellon University',
            'University of Washington', 'Georgia Institute of Technology', 'University of Illinois at Urbana-Champaign',
            'University of Texas at Austin', 'University of Michigan', 'Cornell University', 'Princeton University',
            'Yale University', 'Columbia University', 'University of Pennsylvania', 'Duke University', 'Northwestern University',
            'University of Chicago', 'Johns Hopkins University', 'Brown University', 'Rice University', 'Vanderbilt University',
            'Washington University in St. Louis', 'Emory University', 'Georgetown University', 'University of Notre Dame',
            'University of Virginia', 'University of North Carolina at Chapel Hill', 'Wake Forest University', 'Tufts University',
            'University of Southern California', 'New York University', 'Boston University', 'Northeastern University',
            'University of California, Los Angeles', 'University of California, San Diego', 'University of California, Irvine',
            'University of California, Davis', 'University of California, Santa Barbara', 'University of California, Santa Cruz'
        ];

        $degrees = [
            'Bachelor of Science in Computer Science', 'Bachelor of Science in Software Engineering', 'Bachelor of Science in Information Technology',
            'Bachelor of Science in Data Science', 'Bachelor of Science in Cybersecurity', 'Bachelor of Science in Information Systems',
            'Bachelor of Arts in Computer Science', 'Bachelor of Engineering in Computer Engineering', 'Bachelor of Science in Mathematics',
            'Bachelor of Science in Physics', 'Bachelor of Science in Electrical Engineering', 'Bachelor of Science in Mechanical Engineering',
            'Master of Science in Computer Science', 'Master of Science in Software Engineering', 'Master of Science in Data Science',
            'Master of Science in Information Technology', 'Master of Science in Cybersecurity', 'Master of Business Administration',
            'Master of Science in Artificial Intelligence', 'Master of Science in Machine Learning', 'Master of Science in Human-Computer Interaction',
            'PhD in Computer Science', 'PhD in Software Engineering', 'PhD in Data Science', 'PhD in Artificial Intelligence',
            'Associate Degree in Computer Science', 'Associate Degree in Information Technology', 'Certificate in Web Development',
            'Certificate in Data Analysis', 'Certificate in Cybersecurity', 'Diploma in Software Development'
        ];

        $startDate = $this->faker->dateTimeBetween('-15 years', '-2 years');
        $endDate = $this->faker->dateTimeBetween($startDate, 'now');

        return [
            'college_name' => $this->faker->randomElement($colleges),
            'degree' => $this->faker->randomElement($degrees),
            'start' => $startDate,
            'end' => $endDate,
            'description' => $this->faker->optional(0.6)->paragraphs(1, true),
            'candidate_id' => Candidate::factory(),
            'field_id' => Field::factory(),
        ];
    }

    /**
     * Indicate that the education is current (no end date).
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'end' => null,
        ]);
    }

    /**
     * Indicate that the education is in a specific field.
     */
    public function inField(Field $field): static
    {
        return $this->state(fn (array $attributes) => [
            'field_id' => $field->id,
        ]);
    }
}