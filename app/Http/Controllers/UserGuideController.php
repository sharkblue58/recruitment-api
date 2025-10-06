<?php

namespace App\Http\Controllers;

use App\Models\UserGuide;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = UserGuide::query();

        // Filter by target audience
        if ($request->has('audience')) {
            $query->forAudience($request->audience);
        }

        // Filter by content type
        if ($request->has('content_type')) {
            $query->byContentType($request->content_type);
        }

        // Filter by active status
        if ($request->has('active')) {
            if ($request->boolean('active')) {
                $query->active();
            } else {
                $query->where('is_active', false);
            }
        } else {
            // Default to active only
            $query->active();
        }

        // Get locale for localized content
        $locale = $request->get('locale', 'en');

        $guides = $query->get()->map(function ($guide) use ($locale) {
            return [
                'id' => $guide->id,
                'heading' => $guide->getHeading($locale),
                'content' => $guide->getContent($locale),
                'content_type' => $guide->content_type,
                'target_audience' => $guide->target_audience,
                'is_active' => $guide->is_active,
                'created_at' => $guide->created_at,
                'updated_at' => $guide->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $guides,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'heading' => 'required|array',
            'heading.en' => 'required|string|max:255',
            'heading.ar' => 'required|string|max:255',
            'content' => 'required|array',
            'content.en' => 'required|string',
            'content.ar' => 'required|string',
            'content_type' => 'required|in:faq,terms_privacy',
            'target_audience' => 'required|in:recruiters,candidates',
            'is_active' => 'boolean',
        ]);

        $guide = UserGuide::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User guide created successfully',
            'data' => $guide,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, UserGuide $userGuide): JsonResponse
    {
        $locale = $request->get('locale', 'en');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $userGuide->id,
                'heading' => $userGuide->getHeading($locale),
                'content' => $userGuide->getContent($locale),
                'content_type' => $userGuide->content_type,
                'target_audience' => $userGuide->target_audience,
                'is_active' => $userGuide->is_active,
                'created_at' => $userGuide->created_at,
                'updated_at' => $userGuide->updated_at,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserGuide $userGuide): JsonResponse
    {
        $validated = $request->validate([
            'heading' => 'sometimes|array',
            'heading.en' => 'required_with:heading|string|max:255',
            'heading.ar' => 'required_with:heading|string|max:255',
            'content' => 'sometimes|array',
            'content.en' => 'required_with:content|string',
            'content.ar' => 'required_with:content|string',
            'content_type' => 'sometimes|in:faq,terms_privacy',
            'target_audience' => 'sometimes|in:recruiters,candidates',
            'is_active' => 'sometimes|boolean',
        ]);

        $userGuide->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User guide updated successfully',
            'data' => $userGuide,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserGuide $userGuide): JsonResponse
    {
        $userGuide->delete();

        return response()->json([
            'success' => true,
            'message' => 'User guide deleted successfully',
        ]);
    }

    /**
     * Get guides for a specific audience and content type.
     */
    public function getByAudienceAndType(Request $request, string $audience, string $contentType): JsonResponse
    {
        $locale = $request->get('locale', 'en');

        $guides = UserGuide::active()
            ->forAudience($audience)
            ->byContentType($contentType)
            ->get()
            ->map(function ($guide) use ($locale) {
                return [
                    'id' => $guide->id,
                    'heading' => $guide->getHeading($locale),
                    'content' => $guide->getContent($locale),
                    'content_type' => $guide->content_type,
                    'target_audience' => $guide->target_audience,
                    'is_active' => $guide->is_active,
                    'created_at' => $guide->created_at,
                    'updated_at' => $guide->updated_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $guides,
        ]);
    }
}
