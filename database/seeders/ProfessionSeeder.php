<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Profession;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
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

        // Get some skills for attaching to professions
        $skills = Skill::all();

        // Create professions for each candidate
        foreach ($candidates as $candidate) {
            // Each candidate can have 1-4 professions
            $professionCount = rand(1, 4);
            
            for ($i = 0; $i < $professionCount; $i++) {
                $profession = Profession::factory()->create([
                    'candidate_id' => $candidate->id,
                ]);

                // Attach 2-6 random skills to each profession
                if ($skills->isNotEmpty()) {
                    $skillCount = rand(2, min(6, $skills->count()));
                    $randomSkills = $skills->random($skillCount);
                    $profession->skills()->attach($randomSkills);
                }
            }
        }

        $this->command->info('Professions created and skills attached successfully.');
    }
}