<?php

namespace Tests\Feature;

use App\Models\UserGuide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserGuideTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test getting all user guides.
     */
    public function test_can_get_all_user_guides(): void
    {
        // Create test data
        UserGuide::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/user-guides');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'heading',
                        'content',
                        'content_type',
                        'target_audience',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    /**
     * Test getting user guides with filters.
     */
    public function test_can_filter_user_guides_by_audience(): void
    {
        // Create test data
        UserGuide::factory()->forRecruiters()->active()->count(3)->create();
        UserGuide::factory()->forCandidates()->active()->count(2)->create();

        $response = $this->getJson('/api/v1/user-guides?audience=recruiters');

        $response->assertStatus(200);
        $this->assertEquals(3, count($response->json('data')));
    }

    /**
     * Test getting user guides by content type.
     */
    public function test_can_filter_user_guides_by_content_type(): void
    {
        // Create test data
        UserGuide::factory()->faq()->active()->count(3)->create();
        UserGuide::factory()->termsPrivacy()->active()->count(2)->create();

        $response = $this->getJson('/api/v1/user-guides?content_type=faq');

        $response->assertStatus(200);
        $this->assertEquals(3, count($response->json('data')));
    }

    /**
     * Test getting user guides by audience and content type.
     */
    public function test_can_get_guides_by_audience_and_type(): void
    {
        // Create test data
        UserGuide::factory()->forRecruiters()->faq()->active()->count(2)->create();
        UserGuide::factory()->forCandidates()->faq()->active()->count(1)->create();

        $response = $this->getJson('/api/v1/user-guides/recruiters/faq');

        $response->assertStatus(200);
        $this->assertEquals(2, count($response->json('data')));
    }

    /**
     * Test getting localized content.
     */
    public function test_can_get_localized_content(): void
    {
        $guide = UserGuide::factory()->create([
            'heading' => [
                'en' => 'English Heading',
                'ar' => 'العنوان بالعربية'
            ],
            'content' => [
                'en' => 'English Content',
                'ar' => 'المحتوى بالعربية'
            ]
        ]);

        // Test English locale
        $response = $this->getJson('/api/v1/user-guides/' . $guide->id . '?locale=en');
        $response->assertStatus(200);
        $this->assertEquals('English Heading', $response->json('data.heading'));
        $this->assertEquals('English Content', $response->json('data.content'));

        // Test Arabic locale
        $response = $this->getJson('/api/v1/user-guides/' . $guide->id . '?locale=ar');
        $response->assertStatus(200);
        $this->assertEquals('العنوان بالعربية', $response->json('data.heading'));
        $this->assertEquals('المحتوى بالعربية', $response->json('data.content'));
    }

    /**
     * Test creating a user guide.
     */
    public function test_can_create_user_guide(): void
    {
        $guideData = [
            'heading' => [
                'en' => 'Test Heading',
                'ar' => 'عنوان تجريبي'
            ],
            'content' => [
                'en' => 'Test Content',
                'ar' => 'محتوى تجريبي'
            ],
            'content_type' => 'faq',
            'target_audience' => 'recruiters',
            'is_active' => true
        ];

        $response = $this->postJson('/api/v1/user-guides', $guideData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'heading',
                    'content',
                    'content_type',
                    'target_audience',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseHas('user_guides', [
            'content_type' => 'faq',
            'target_audience' => 'recruiters',
            'is_active' => true
        ]);
    }

    /**
     * Test updating a user guide.
     */
    public function test_can_update_user_guide(): void
    {
        $guide = UserGuide::factory()->create();

        $updateData = [
            'heading' => [
                'en' => 'Updated Heading',
                'ar' => 'عنوان محدث'
            ],
            'is_active' => false
        ];

        $response = $this->putJson('/api/v1/user-guides/' . $guide->id, $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('user_guides', [
            'id' => $guide->id,
            'is_active' => false
        ]);
    }

    /**
     * Test deleting a user guide.
     */
    public function test_can_delete_user_guide(): void
    {
        $guide = UserGuide::factory()->create();

        $response = $this->deleteJson('/api/v1/user-guides/' . $guide->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);

        $this->assertDatabaseMissing('user_guides', [
            'id' => $guide->id
        ]);
    }

    /**
     * Test validation errors for creating user guide.
     */
    public function test_validation_errors_for_creating_user_guide(): void
    {
        $response = $this->postJson('/api/v1/user-guides', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'heading',
                'content',
                'content_type',
                'target_audience'
            ]);
    }

    /**
     * Test validation errors for updating user guide.
     */
    public function test_validation_errors_for_updating_user_guide(): void
    {
        $guide = UserGuide::factory()->create();

        $response = $this->putJson('/api/v1/user-guides/' . $guide->id, [
            'content_type' => 'invalid_type'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['content_type']);
    }

    /**
     * Test getting single user guide.
     */
    public function test_can_get_single_user_guide(): void
    {
        $guide = UserGuide::factory()->create();

        $response = $this->getJson('/api/v1/user-guides/' . $guide->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'heading',
                    'content',
                    'content_type',
                    'target_audience',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /**
     * Test getting only active guides by default.
     */
    public function test_gets_only_active_guides_by_default(): void
    {
        UserGuide::factory()->active()->count(3)->create();
        UserGuide::factory()->inactive()->count(2)->create();

        $response = $this->getJson('/api/v1/user-guides');

        $response->assertStatus(200);
        $this->assertEquals(3, count($response->json('data')));
    }

    /**
     * Test getting inactive guides when requested.
     */
    public function test_can_get_inactive_guides_when_requested(): void
    {
        UserGuide::factory()->active()->count(2)->create();
        UserGuide::factory()->inactive()->count(3)->create();

        $response = $this->getJson('/api/v1/user-guides?active=false');

        $response->assertStatus(200);
        $this->assertEquals(3, count($response->json('data')));
    }
}
