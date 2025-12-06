<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserupdateRequest extends FormRequest
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
            
           'password' => 'required|string|min:8|bail',
        ];
    }

    public function messages(): array
    {
        return [
            
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            
        ];
    }
}
 