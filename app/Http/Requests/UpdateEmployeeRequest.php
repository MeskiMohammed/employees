<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
        $employeeId = $this->route('employee');
        $userId = $this->employee->user_id;

        return [
            // User information
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => 'nullable|string|min:8',

            // Basic employee information
            'personal_num' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'cin' => ['required','string','max:255',Rule::unique('employees', 'cin')->ignore($employeeId),],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cin_attachment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'department_ids' => 'required|array',
            'department_ids.*' => 'exists:departments,id',
            'is_freelancer' => 'required|in:employee,freelancer,trainee',

            // Employee specific fields
            'employee_code' => ['nullable','string','max:255',Rule::unique('employees', 'employee_code')->ignore($employeeId),],
            'salary' => 'nullable|numeric|min:0',
            'professional_num' => 'nullable|string|max:255',
            'professional_email' => ['nullable','email',Rule::unique('employees', 'professional_email')->ignore($employeeId),],
            'pin' => 'nullable|string|max:255',
            'puk' => 'nullable|string|max:255',
            'operator_id' => 'nullable|exists:operators,id',
            'cnss' => 'nullable|string|max:255',
            'assurance' => 'nullable|string|max:255',
            'type_id' => 'nullable|exists:types,id',

            // Freelancer specific fields
            'ice' => ['nullable','string','max:255',Rule::requiredIf(fn() => $this->is_freelancer === 'freelancer'),Rule::unique('employees', 'ice')->ignore($employeeId),],
            'is_project' => 'nullable|boolean',
            'is_anapec' => 'nullable|boolean',
            'hourly_salary'=> 'nullable|numeric',
            // Attachments for employee
            'employment_contract' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'job_application' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'insurance' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'resume' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cnss_certificate' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Attachments for freelancer
            'eic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Attachments for trainee
            'internship_agreement' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'internship_application' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'insurance_int' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'resume_int' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'transcript' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }


    public function withValidator($validator)
    {
        $validator->sometimes([
                'professional_num',
                'pin',
                'puk',
                'operator_id',
                'professional_email',
                'cnss',
                'assurance',
                'type_id',
                'salary',
            ], 'required', function ($input) {return $input->is_freelancer === 'employee';}
        );

        $validator->sometimes('ice', 'required', function ($input) {
            return $input->is_freelancer === 'freelancer';
        });


        $validator->sometimes('hourly_salary', 'required', function ($input) {
            return $input->is_freelancer === 'freelancer' && !$input->has('is_project');
        });

        $validator->sometimes([
                'training_type',
            ], 'required', function ($input) {return $input->is_freelancer === 'trainee';}
        );

        $validator->sometimes('school', 'required', function ($input) {
            return $input->is_freelancer === 'trainee' && !$input->training_type === 'student';
        });
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'department_ids.*' => 'department',
            'employment_contract' => 'employment contract',
            'job_application' => 'job application',
            'cnss_certificate' => 'CNSS certificate',
            'eic' => 'entrepreneur identification card',
            'internship_agreement' => 'internship agreement',
            'internship_application' => 'internship application',
            'insurance_int' => 'insurance',
            'resume_int' => 'resume',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'department_ids.required' => 'Please select at least one department.',
            'ice.required_if' => 'The ICE field is required for freelancers.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_project' => $this->has('is_project'),
        ]);
    }
}
