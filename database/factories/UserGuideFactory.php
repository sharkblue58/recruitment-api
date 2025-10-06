<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserGuide>
 */
class UserGuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contentTypes = ['faq', 'terms_privacy'];
        $targetAudiences = ['recruiters', 'candidates'];
        
        return [
            'heading' => [
                'en' => $this->faker->sentence(6),
                'ar' => 'عنوان باللغة العربية: ' . $this->faker->sentence(4),
            ],
            'content' => [
                'en' => $this->faker->paragraphs(3, true),
                'ar' => 'محتوى باللغة العربية: ' . $this->faker->paragraphs(2, true),
            ],
            'content_type' => $this->faker->randomElement($contentTypes),
            'target_audience' => $this->faker->randomElement($targetAudiences),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Create a FAQ guide.
     */
    public function faq(): static
    {
        return $this->state(fn (array $attributes) => [
            'content_type' => 'faq',
            'heading' => [
                'en' => 'Frequently Asked Questions',
                'ar' => 'الأسئلة الشائعة',
            ],
        ]);
    }

    /**
     * Create a terms and privacy guide.
     */
    public function termsPrivacy(): static
    {
        return $this->state(fn (array $attributes) => [
            'content_type' => 'terms_privacy',
            'heading' => [
                'en' => 'Terms and Privacy Policy',
                'ar' => 'الشروط وسياسة الخصوصية',
            ],
        ]);
    }

    /**
     * Create a guide for recruiters.
     */
    public function forRecruiters(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_audience' => 'recruiters',
        ]);
    }

    /**
     * Create a guide for candidates.
     */
    public function forCandidates(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_audience' => 'candidates',
        ]);
    }


    /**
     * Create an active guide.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Create an inactive guide.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
