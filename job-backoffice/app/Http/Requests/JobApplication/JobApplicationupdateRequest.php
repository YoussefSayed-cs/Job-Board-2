<?php

namespace App\Http\Requests\JobCategory;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
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
            
            'status' => 'bail|required|string|in:Pending,Accepted,Rejected'
        ];
    }

    public function messages(): array
    {
        return [
            'status.in'=> 'The status field must be one of the following: Pending, Accepted, Rejected.',
            'status.required' => 'The status field is required. '
            
        ];
    }
}
 