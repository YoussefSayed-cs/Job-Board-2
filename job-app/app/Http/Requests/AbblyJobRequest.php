<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbblyJobRequest extends FormRequest
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
        'resume_option' => 'required|string',
        'resume_file' => 'required_if:resume_option,new_resume|file|mimes:pdf|max:5120',
    ];
}
    public function messages(): array
{
    return [
        'resume_option.required' => 'Please select a resume option.',

        'resume_file.required_if' => 'Please upload your resume when choosing a new resume.',
        'resume_file.file' => 'The resume must be a valid file.',
        'resume_file.mimes' => 'Only PDF files are allowed.',
        'resume_file.max' => 'The resume size must not exceed 5MB.',
    ];
}

}
