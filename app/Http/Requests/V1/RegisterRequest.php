<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:candidate,recruiter',
            'field_id' => 'required|exists:fields,id',
            'is_term_accepted' =>  'accepted',
        ];

        if ($this->role == 'recruiter') {

            $rules = array_merge($rules, [
                'job_title' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
            ]);
        }

        return $rules;
    }
}
