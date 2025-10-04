<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Recruiter;
use App\Models\Field;
use App\Models\City;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->field = Field::factory()->create();
        $this->country = Country::factory()->create();
        $this->city = City::factory()->create(['country_id' => $this->country->id]);
    }

    /**
     * Test getting user profile.
     */
    public function test_can_get_user_profile(): void
    {
        $user = User::factory()->create();
        $recruiter = Recruiter::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')
            ->getJson('/api/v1/profile');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'user' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'is_term_accepted',
                        'field',
                        'city',
                        'created_at',
                        'updated_at',
                    ],
                    'recruiter',
                    'candidate',
                ]
            ]);
    }

    /**
     * Test updating user profile.
     */
    public function test_can_update_user_profile(): void
    {
        $user = User::factory()->create();

        $updateData = [
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'phone' => '1234567890',
            'field_id' => $this->field->id,
            'city_id' => $this->city->id,
        ];

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile', $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'is_term_accepted',
                        'field',
                        'city',
                        'created_at',
                        'updated_at',
                    ],
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'phone' => '1234567890',
            'field_id' => $this->field->id,
            'city_id' => $this->city->id,
        ]);
    }

    /**
     * Test updating user email.
     */
    public function test_can_update_user_email(): void
    {
        $user = User::factory()->create();

        $updateData = [
            'email' => 'newemail@example.com',
        ];

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile', $updateData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'newemail@example.com',
        ]);
    }

    /**
     * Test updating password.
     */
    public function test_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $updateData = [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile/password', $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Password updated successfully',
            ]);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    /**
     * Test password update with incorrect current password.
     */
    public function test_cannot_update_password_with_incorrect_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $updateData = [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile/password', $updateData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Current password is incorrect',
            ]);
    }

    /**
     * Test updating recruiter profile.
     */
    public function test_can_update_recruiter_profile(): void
    {
        $user = User::factory()->create();
        $recruiter = Recruiter::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'company_name' => 'Updated Company',
            'job_title' => 'Updated Job Title',
        ];

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile/recruiter', $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'company_name',
                    'job_title',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseHas('recruiters', [
            'id' => $recruiter->id,
            'company_name' => 'Updated Company',
            'job_title' => 'Updated Job Title',
        ]);
    }

    /**
     * Test updating recruiter profile for non-recruiter user.
     */
    public function test_cannot_update_recruiter_profile_for_non_recruiter(): void
    {
        $user = User::factory()->create();

        $updateData = [
            'company_name' => 'Updated Company',
            'job_title' => 'Updated Job Title',
        ];

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile/recruiter', $updateData);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'User is not a recruiter',
            ]);
    }

    /**
     * Test getting available fields.
     */
    public function test_can_get_available_fields(): void
    {
        Field::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/fields');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                    ]
                ]
            ]);
    }

    /**
     * Test getting available cities.
     */
    public function test_can_get_available_cities(): void
    {
        City::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/cities');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'country_id',
                        'country' => [
                            'id',
                            'name',
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Test creating new field.
     */
    public function test_can_create_new_field(): void
    {
        $fieldData = [
            'title' => 'New Field Title',
        ];

        $response = $this->postJson('/api/v1/fields', $fieldData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'title',
                    'is_system_field',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseHas('fields', [
            'title' => 'New Field Title',
            'is_system_field' => false,
        ]);
    }

    /**
     * Test validation errors for profile update.
     */
    public function test_validation_errors_for_profile_update(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile', [
                'email' => 'invalid-email',
                'field_id' => 999,
                'city_id' => 999,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
                'field_id',
                'city_id',
            ]);
    }

    /**
     * Test validation errors for password update.
     */
    public function test_validation_errors_for_password_update(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile/password', [
                'current_password' => '',
                'password' => '123',
                'password_confirmation' => '456',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'current_password',
                'password',
            ]);
    }

    /**
     * Test validation errors for recruiter profile update.
     */
    public function test_validation_errors_for_recruiter_profile_update(): void
    {
        $user = User::factory()->create();
        $recruiter = Recruiter::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/v1/profile/recruiter', [
                'company_name' => str_repeat('a', 256), // Too long
                'job_title' => str_repeat('b', 256), // Too long
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'company_name',
                'job_title',
            ]);
    }

    /**
     * Test unauthorized access to profile endpoints.
     */
    public function test_unauthorized_access_to_profile_endpoints(): void
    {
        $response = $this->getJson('/api/v1/profile');
        $response->assertStatus(401);

        $response = $this->putJson('/api/v1/profile', []);
        $response->assertStatus(401);

        $response = $this->putJson('/api/v1/profile/password', []);
        $response->assertStatus(401);

        $response = $this->putJson('/api/v1/profile/recruiter', []);
        $response->assertStatus(401);
    }
}
