<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow anyone who can reach this controller
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'department_ids' => 'required|array|min:1',
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg', 'dimensions:width=1080,height=1080,ratio=1/1'],
            'personal_num' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'cin' => 'required|string|max:8|unique:employees',
            'cin_attachment' => 'required|image|mimes:jpeg,png,jpg',

            'is_freelancer' => 'required|string',
            'is_project' => 'nullable|boolean',
            'salary' => 'nullable|numeric', // handled conditionally below

            // optional employee/freelancer fields conditionally validated
            'professional_num' => 'nullable|string|max:255',
            'pin' => 'nullable|string|max:255',
            'puk' => 'nullable|string|max:255',
            'operator_id' => 'nullable|exists:operators,id',
            'professional_email' => 'nullable|email|max:255',
            'cnss' => 'nullable|string|max:255',
            'assurance' => 'nullable|string|max:255',
            'type_id' => 'nullable|exists:types,id',
            'ice' => 'nullable|string|max:255',
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
                'employment_contract',
                'job_application',
                'insurance',
                'resume',
                'cnss_certificate',
            ], 'required', function ($input) {return $input->is_freelancer === 'employee';}
        );

        $validator->sometimes(['ice','eic'], 'required', function ($input) {
            return $input->is_freelancer === 'freelancer';
        });


        $validator->sometimes('salary_free', 'required', function ($input) {
            return $input->is_freelancer === 'freelancer' && !$input->has('is_project');
        });

        $validator->sometimes([
                'internship_agreement',
                'internship_application',
                'insurance_int',
                'resume_int',
                'transcript',
            ], 'required', function ($input) {return $input->is_freelancer === 'trainee';}
        );
    }

    public function messages()
    {
        return [
            'first_name.required' => 'The first name is required.',
            'first_name.string' => 'The first name must be a valid text.',
            'first_name.max' => 'The first name may not be greater than 255 characters.',

            'last_name.required' => 'The last name is required.',
            'last_name.string' => 'The last name must be a valid text.',
            'last_name.max' => 'The last name may not be greater than 255 characters.',

            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email address may not be greater than 255 characters.',
            'email.unique' => 'This email address is already in use.',

            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters long.',

            'department_ids.required' => 'Please select at least one department.',
            'department_ids.array' => 'Invalid departments format.',

            'profile_picture.required' => 'A profile picture is required.',
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'The profile picture must be a JPEG or PNG file.',
            'profile_picture.dimensions' => 'The profile picture must be exactly 1080x1080 pixels and have a 1:1 ratio.',

            'personal_num.required' => 'The personal phone number is required.',
            'personal_num.string' => 'The personal phone number must be valid text.',
            'personal_num.max' => 'The personal phone number may not exceed 255 characters.',

            'address.required' => 'The address is required.',
            'address.string' => 'The address must be valid text.',
            'address.max' => 'The address may not exceed 255 characters.',

            'cin.required' => 'The CIN is required.',
            'cin.string' => 'The CIN must be valid text.',
            'cin.max' => 'The CIN must not exceed 8 characters.',
            'cin.unique' => 'This CIN is already registered.',

            'cin_attachment.required' => 'The CIN attachment is required.',
            'cin_attachment.image' => 'The CIN attachment must be an image.',
            'cin_attachment.mimes' => 'The CIN attachment must be a JPEG or PNG file.',

            // Freelancer specific
            'ice.required_if' => 'The ICE is required for freelancers.',
            'ice.string' => 'The ICE must be valid text.',
            'ice.max' => 'The ICE may not exceed 255 characters.',

            // If not project, salary required
            'salary.required_unless' => 'The salary is required unless the employee is assigned to a project.',
            'salary.required_if' => 'The salary is required unless the employee is assigned to a project.',
            'salary.numeric' => 'The salary must be a numeric value.',

            // Employee specific
            'professional_num.required_if' => 'The professional number is required for employees.',
            'professional_num.string' => 'The professional number must be valid text.',
            'professional_num.max' => 'The professional number may not exceed 255 characters.',

            'professional_email.required_if' => 'The professional email is required for employees.',
            'professional_email.email' => 'Please provide a valid professional email address.',
            'professional_email.max' => 'The professional email may not exceed 255 characters.',

            'pin.required_if' => 'The SIM PIN is required for employees.',
            'pin.string' => 'The SIM PIN must be valid text.',
            'pin.max' => 'The SIM PIN may not exceed 255 characters.',

            'puk.required_if' => 'The SIM PUK is required for employees.',
            'puk.string' => 'The SIM PUK must be valid text.',
            'puk.max' => 'The SIM PUK may not exceed 255 characters.',

            'operator_id.required_if' => 'Please select a mobile operator for employees.',
            'operator_id.exists' => 'The selected operator is invalid.',

            'cnss.required_if' => 'The CNSS number is required for employees.',
            'cnss.string' => 'The CNSS number must be valid text.',
            'cnss.max' => 'The CNSS number may not exceed 255 characters.',

            'assurance.required_if' => 'The insurance information is required for employees.',
            'assurance.string' => 'The insurance information must be valid text.',
            'assurance.max' => 'The insurance information may not exceed 255 characters.',

            'type_id.required_if' => 'Please select the employee type.',
            'type_id.exists' => 'The selected type is invalid.',
    ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'password' => 'Password',
            'department_ids' => 'Departments',
            'profile_picture' => 'Profile Picture',
            'personal_num' => 'Personal Phone Number',
            'address' => 'Address',
            'cin' => 'CIN',
            'cin_attachment' => 'CIN Attachment',
            'ice' => 'ICE',
            'salary' => 'Salary',
            'professional_num' => 'Professional Phone Number',
            'professional_email' => 'Professional Email Address',
            'pin' => 'SIM PIN',
            'puk' => 'SIM PUK',
            'operator_id' => 'Mobile Operator',
            'cnss' => 'CNSS Number',
            'assurance' => 'Insurance',
            'type_id' => 'Employee Type',
    ];
    }

}

