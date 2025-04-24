@extends('layout.app')

@section('title', 'Create Employee')

@section('header', 'Create Employee')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Create New Employee</h2>
        </div>

        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{freelancer : false}">
                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                </div>

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('first_name') border-red-500 @enderror" required>
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('last_name') border-red-500 @enderror" required>
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="text" name="password" id="password" value="{{ old('password') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cin" class="block text-sm font-medium text-gray-700 mb-1">CIN</label>
                    <input type="text" name="cin" id="cin" value="{{ old('cin') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('cin') border-red-500 @enderror" required>
                    @error('cin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select name="department_id" id="department_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('department_id') border-red-500 @enderror" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="operator_id" class="block text-sm font-medium text-gray-700 mb-1">Operator</label>
                    <select name="operator_id" id="operator_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('operator_id') border-red-500 @enderror">
                        <option value="">Select Operator</option>
                        @foreach($operators as $operator)
                            <option value="{{ $operator->id }}" {{ old('operator_id') == $operator->id ? 'selected' : '' }}>
                                {{ $operator->operator }}
                            </option>
                        @endforeach
                    </select>
                    @error('operator_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status_id" id="status_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('status_id') border-red-500 @enderror" required>
                        <option value="">Select Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                </div>

                <div>
                    <label for="professional_email" class="block text-sm font-medium text-gray-700 mb-1">Professional Email</label>
                    <input type="email" name="professional_email" id="professional_email" value="{{ old('professional_email') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('professional_email') border-red-500 @enderror">
                    @error('professional_email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="professional_num" class="block text-sm font-medium text-gray-700 mb-1">Professional Number</label>
                    <input type="text" name="professional_num" id="professional_num" value="{{ old('professional_num') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('professional_num') border-red-500 @enderror">
                    @error('professional_num')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="personal_num" class="block text-sm font-medium text-gray-700 mb-1">Personal Number</label>
                    <input type="text" name="personal_num" id="personal_num" value="{{ old('personal_num') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('personal_num') border-red-500 @enderror">
                    @error('personal_num')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-3">
                    <label for="adress" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="adress" id="adress" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('adress') border-red-500 @enderror">{{ old('adress') }}</textarea>
                    @error('adress')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Employment Details</h3>
                </div>

                <div>
                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Salary</label>
                    <input type="number" name="salary" id="salary" step="0.01" min="0" value="{{ old('salary') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('salary') border-red-500 @enderror">
                    @error('salary')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="is_project" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                        <input type="checkbox" name="is_project" id="is_project" value="1" {{ old('is_project') ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        <span class="ml-2">Is Project Based</span>
                    </label>
                    @error('is_project')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="houres" class="block text-sm font-medium text-gray-700 mb-1">Hours</label>
                    <input type="number" name="houres" id="houres" min="0" value="{{ old('houres') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('houres') border-red-500 @enderror">
                    @error('houres')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                </div>

                <div>
                    <label for="pin" class="block text-sm font-medium text-gray-700 mb-1">PIN</label>
                    <input type="text" name="pin" id="pin" value="{{ old('pin') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('pin') border-red-500 @enderror">
                    @error('pin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="puk" class="block text-sm font-medium text-gray-700 mb-1">PUK</label>
                    <input type="text" name="puk" id="puk" value="{{ old('puk') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('puk') border-red-500 @enderror">
                    @error('puk')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label for="cnss" class="block text-sm font-medium text-gray-700 mb-1">CNSS</label>
                    <input type="text" name="cnss" id="cnss" value="{{ old('cnss') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('cnss') border-red-500 @enderror">
                    @error('cnss')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="assurance" class="block text-sm font-medium text-gray-700 mb-1">Assurance</label>
                    <input type="text" name="assurance" id="assurance" value="{{ old('assurance') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('assurance') border-red-500 @enderror">
                    @error('assurance')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('profile_picture') border-red-500 @enderror">
                    @error('profile_picture')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <input type='checkbox' @click="freelancer=!freelancer">

                <div x-show="freelancer">freelancer</div>
                <div x-show="!freelancer">employee</div>

                <!-- Freelancer Based Informations
                <div>
                    <label for="ice" class="block text-sm font-medium text-gray-700 mb-1">ICE</label>
                    <input type="text" name="ice" id="ice" value="{{ old('ice') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('ice') border-red-500 @enderror">
                    @error('ice')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                -->
                <!-- Employee Based Informations
                <div>
                    <label for="employee_code" class="block text-sm font-medium text-gray-700 mb-1">Employee Code</label>
                    <input type="text" name="employee_code" id="employee_code" value="{{ old('employee_code') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('employee_code') border-red-500 @enderror" required>
                    @error('employee_code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                 ->


            </div>

            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Employee
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
