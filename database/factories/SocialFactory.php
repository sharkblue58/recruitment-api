<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Social>
 */
class SocialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $providers = ['google', 'facebook', 'linkedin', 'github', 'twitter', 'instagram'];
        $provider = $this->faker->randomElement($providers);

        return [
            'user_id' => User::factory(),
            'provider' => $provider,
            'provider_id' => $this->faker->optional(0.8)->numerify('##########'),
            'avatar' => $this->faker->optional(0.7)->imageUrl(200, 200, 'people'),
        ];
    }

    /**
     * Indicate that the social account is for Google.
     */
    public function google(): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => 'google',
            'provider_id' => $this->faker->numerify('##########'),
            'avatar' => $this->faker->imageUrl(200, 200, 'people'),
        ]);
    }

    /**
     * Indicate that the social account is for LinkedIn.
     */
    public function linkedin(): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => 'linkedin',
            'provider_id' => $this->faker->numerify('##########'),
            'avatar' => $this->faker->imageUrl(200, 200, 'people'),
        ]);
    }

    /**
     * Indicate that the social account is for GitHub.
     */
    public function github(): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => 'github',
            'provider_id' => $this->faker->numerify('##########'),
            'avatar' => $this->faker->imageUrl(200, 200, 'people'),
        ]);
    }

    /**
     * Indicate that the social account is for Facebook.
     */
    public function facebook(): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => 'facebook',
            'provider_id' => $this->faker->numerify('##########'),
            'avatar' => $this->faker->imageUrl(200, 200, 'people'),
        ]);
    }
}