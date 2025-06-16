<?php

namespace App\Http\Requests\ClientRequest\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateProfileRequest extends FormRequest
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
        
         return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id), // exclude current user email for unique check
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048', // max 2MB
        ];
    }
}
