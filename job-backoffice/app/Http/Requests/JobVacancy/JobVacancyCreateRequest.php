<?php

namespace App\Http\Requests\JobVacancy;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            
            'title' => 'required|string|max:255|unique:job_vacancies,title',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'type' => 'required|string|max:50',
            'categoryID' => 'required|exists:job_categories,id',
            'companyID' => 'required|exists:companies,id',
            
        ];
    }

    public function messages(): array   
    {
        return [

            'title.required'=> 'The job title field is required.',
            'title.unique' => 'The job title has already been taken. ',
            'title.max' => 'The job title must be less than 255 characters. ',
            'title.string' => 'The job title must be a srting. ',

            'description.required'=> 'The job description field is required.',
            'description.string' => 'The job description must be a srting. ',

            'location.required'=> 'The job location field is required.',
            'location.max' => 'The job location must be less than 255 characters. ',
            'location.string' => 'The job location must be a srting. ',

            'salary.required'=> 'The job salary field is required.',
            'salary.numeric' => 'The job salary must be a number. ',
            'salary.min' => 'The job salary must be at least 0. ',

            'type.required'=> 'The job type field is required.',
            'type.string' => 'The job type must be a srting. ',
            'type.max' => 'The job type must be less than 50 characters. ',

            'categoryID.required'=> 'The job category field is required.',
            'categoryID.max' => 'The job category must be less than 255 characters.',
            'categoryID.string' => 'The job category must be a string.',

            'companyID.required'=> 'The company field is required.',
            'companyID.string'=>'The company must be string',
            'companyID.max'=>'The company must be less than 255 characters'
        ];
    }
}
