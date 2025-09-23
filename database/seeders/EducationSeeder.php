<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Education;
use App\Models\Field;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all candidates
        $candidates = Candidate::all();
        
        if ($candidates->isEmpty()) {
            $this->command->warn('No candidates found. Please run CandidateSeeder first.');
            return;
        }

        // Get all fields
        $fields = Field::all();
        
        if ($fields->isEmpty()) {
            $this->command->warn('No fields found. Please run FieldSeeder first.');
            return;
        }

        // Get some skills for attaching to educations
        $skills = Skill::all();

        // Create educations for each candidate
        foreach ($candidates as $candidate) {
            // Each candidate can have 1-3 educations
            $educationCount = rand(1, 3);
            
            for ($i = 0; $i < $educationCount; $i++) {
                $education = Education::factory()->create([
                    'candidate_id' => $candidate->id,
                    'field_id' => $fields->random()->id,
                ]);

                // Attach 1-4 random skills to each education
                if ($skills->isNotEmpty()) {
                    $skillCount = rand(1, min(4, $skills->count()));
                    $randomSkills = $skills->random($skillCount);
                    $education->skills()->attach($randomSkills);
                }
            }
        }

        $this->command->info('Educations created and skills attached successfully.');
    }
}