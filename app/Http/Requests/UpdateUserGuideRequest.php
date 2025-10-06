<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserGuideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Add proper authorization logic here
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'heading' => 'sometimes|array',
            'heading.en' => 'required_with:heading|string|max:255',
            'heading.ar' => 'required_with:heading|string|max:255',
            'content' => 'sometimes|array',
            'content.en' => 'required_with:content|string',
            'content.ar' => 'required_with:content|string',
            'content_type' => 'sometimes|in:faq,terms_privacy',
            'target_audience' => 'sometimes|in:recruiters,candidates',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'heading.en.required_with' => 'English heading is required when heading is provided',
            'heading.ar.required_with' => 'Arabic heading is required when heading is provided',
            'content.en.required_with' => 'English content is required when content is provided',
            'content.ar.required_with' => 'Arabic content is required when content is provided',
            'content_type.in' => 'Content type must be either faq or terms_privacy',
            'target_audience.in' => 'Target audience must be either recruiters or candidates',
        ];
    }
}
