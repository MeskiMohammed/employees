@extends('layout.app')

@section('title', 'Edit Employee')

@section('header', 'Edit Employee')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Edit Employee</h2>
        </div>
        
        <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                </div>
                
                <div>
                    <label for="users_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                    <select name="users_id" id="users_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('users_id') border-red-500 @enderror" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('users_id', $employee->users_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->full_name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('users_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="employee_code" class="block text-sm font-medium text-gray-700 mb-1">Employee Code</label>
                    <input type="text" name="employee_code" id="employee_code" value="{{ old('employee_code', $employee->employee_code) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('employee_code') border-red-500 @enderror" required>
                    @error('employee_code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="cin" class="block text-sm font-medium text-gray-700 mb-1">CIN</label>
                    <input type="text" name="cin" id="cin" value="{{ old('cin', $employee->cin) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('cin') border-red-500 @enderror" required>
                    @error('cin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select name="department_id" id="department_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('department_id') border-red-500 @enderror" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
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
                            <option value="{{ $operator->id }}" {{ old('operator_id', $employee->operator_id) == $operator->id ? 'selected' : '' }}>
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
                            <option value="{{ $status->id }}" {{ old('status_id', $employee->status_id) == $status->id ? 'selected' : '' }}>
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
                    <input type="email" name="professional_email" id="professional_email" value="{{ old('professional_email', $employee->professional_email) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('professional_email') border-red-500 @enderror">
                    @error('professional_email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="professional_num" class="block text-sm font-medium text-gray-700 mb-1">Professional Number</label>
                    <input type="text" name="professional_num" id="professional_num" value="{{ old('professional_num', $employee->professional_num) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('professional_num') border-red-500 @enderror">
                    @error('professional_num')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="personal_num" class="block text-sm font-medium text-gray-700 mb-1">Personal Number</label>
                    <input type="text" name="personal_num" id="personal_num" value="{{ old('personal_num', $employee->personal_num) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('personal_num') border-red-500 @enderror">
                    @error('personal_num')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-3">
                    <label for="adress" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="adress" id="adress" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('adress') border-red-500 @enderror">{{ old('adress', $employee->adress) }}</textarea>
                    @error('adress')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Employment Details</h3>
                </div>
                
                <div>
                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Salary</label>
                    <input type="number" name="salary" id="salary" step="0.01" min="0" value="{{ old('salary', $employee->salary) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('salary') border-red-500 @enderror">
                    @error('salary')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="is_project" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                        <input type="checkbox" name="is_project" id="is_project" value="1" {{ old('is_project', $employee->is_project) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        <span class="ml-2">Is Project Based</span>
                    </label>
                    @error('is_project')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="houres" class="block text-sm font-medium text-gray-700 mb-1">Hours</label>
                    <input type="number" name="houres" id="houres" min="0" value="{{ old('houres', $employee->houres) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('houres') border-red-500 @enderror">
                    @error('houres')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                </div>
                
                <div>
                    <label for="pin" class="block text-sm font-medium text-gray-700 mb-1">PIN</label>
                    <input type="text" name="pin" id="pin" value="{{ old('pin', $employee->pin) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('pin') border-red-500 @enderror">
                    @error('pin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="puk" class="block text-sm font-medium text-gray-700 mb-1">PUK</label>
                    <input type="text" name="puk" id="puk" value="{{ old('puk', $employee->puk) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('puk') border-red-500 @enderror">
                    @error('puk')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="ice" class="block text-sm font-medium text-gray-700 mb-1">ICE</label>
                    <input type="text" name="ice" id="ice" value="{{ old('ice', $employee->ice) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('ice') border-red-500 @enderror">
                    @error('ice')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="cnss" class="block text-sm font-medium text-gray-700 mb-1">CNSS</label>
                    <input type="text" name="cnss" id="cnss" value="{{ old('cnss', $employee->cnss) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('cnss') border-red-500 @enderror">
                    @error('cnss')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="assurance" class="block text-sm font-medium text-gray-700 mb-1">Assurance</label>
                    <input type="text" name="assurance" id="assurance" value="{{ old('assurance', $employee->assurance) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('assurance') border-red-500 @enderror">
                    @error('assurance')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    @if($employee->profile_picture)
                        <div class="mb-2">
                            <img src="{{ Storage::url($employee->profile_picture) }}" alt="Current profile picture" class="h-20 w-20 rounded-full object-cover">
                            <p class="text-xs text-gray-500 mt-1">Current profile picture</p>
                        </div>
                    @endif
                    <input type="file" name="profile_picture" id="profile_picture" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('profile_picture') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current picture</p>
                    @error('profile_picture')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Employee
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
