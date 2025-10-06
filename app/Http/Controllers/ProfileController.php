<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recruiter;
use App\Models\Field;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Get the authenticated user's profile.
     */
    public function show(): JsonResponse
    {
        $user = Auth::user();
        $user->load(['field', 'city', 'recruiter', 'candidate']);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'is_term_accepted' => $user->is_term_accepted,
                    'field' => $user->field,
                    'city' => $user->city,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ],
                'recruiter' => $user->recruiter,
                'candidate' => $user->candidate,
            ],
        ]);
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request): JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'sometimes|string|max:20',
            'field_id' => 'sometimes|nullable|exists:fields,id',
            'city_id' => 'sometimes|nullable|exists:cities,id',
        ]);

        $user->update($validated);
        $user->load(['field', 'city']);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'is_term_accepted' => $user->is_term_accepted,
                    'field' => $user->field,
                    'city' => $user->city,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ],
            ],
        ]);
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }

    /**
     * Update recruiter profile.
     */
    public function updateRecruiterProfile(Request $request): JsonResponse
    {
        $user = Auth::user();
        $recruiter = $user->recruiter;

        if (!$recruiter) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a recruiter',
            ], 403);
        }

        $validated = $request->validate([
            'company_name' => 'sometimes|string|max:255',
            'job_title' => 'sometimes|string|max:255',
        ]);

        $recruiter->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Recruiter profile updated successfully',
            'data' => $recruiter,
        ]);
    }

    /**
     * Get available fields for selection.
     */
    public function getFields(): JsonResponse
    {
        $fields = Field::select('id', 'title')->get();

        return response()->json([
            'success' => true,
            'data' => $fields,
        ]);
    }

    /**
     * Get available cities for selection.
     */
    public function getCities(): JsonResponse
    {
        $cities = City::with('country:id,name')
            ->select('id', 'name', 'country_id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cities,
        ]);
    }

    /**
     * Create a new field if it doesn't exist.
     */
    public function createField(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:fields,title',
        ]);

        $field = Field::create([
            'title' => $validated['title'],
            'is_system_field' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field created successfully',
            'data' => $field,
        ], 201);
    }
}
