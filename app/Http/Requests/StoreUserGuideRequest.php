<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserGuideRequest extends FormRequest
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
            'heading' => 'required|array',
            'heading.en' => 'required|string|max:255',
            'heading.ar' => 'required|string|max:255',
            'content' => 'required|array',
            'content.en' => 'required|string',
            'content.ar' => 'required|string',
            'content_type' => 'required|in:faq,terms_privacy',
            'target_audience' => 'required|in:recruiters,candidates',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'heading.required' => 'Heading is required',
            'heading.en.required' => 'English heading is required',
            'heading.ar.required' => 'Arabic heading is required',
            'content.required' => 'Content is required',
            'content.en.required' => 'English content is required',
            'content.ar.required' => 'Arabic content is required',
            'content_type.required' => 'Content type is required',
            'content_type.in' => 'Content type must be either faq or terms_privacy',
            'target_audience.required' => 'Target audience is required',
            'target_audience.in' => 'Target audience must be either recruiters or candidates',
        ];
    }
}
