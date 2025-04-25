@extends('layout.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Edit Your Profile</h1>
        <p class="mt-1 text-sm text-gray-500">Update your personal information and settings.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Personal Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Update your basic information.</p>
        </div>

        <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <div class="flex items-center">
                            @if($employee->profile_picture)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="{{ $employee->first_name }} {{ $employee->last_name }}" class="h-24 w-24 rounded-full object-cover">
                                    <div class="absolute inset-0 rounded-full shadow-inner"></div>
                                </div>
                            @else
                                <div class="h-24 w-24 rounded-full bg-emerald-600 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-white">{{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="ml-5">
                                <div class="relative rounded-md shadow-sm">
                                    <input type="file" name="profile_picture" id="profile_picture" class="sr-only">
                                    <label for="profile_picture" class="cursor-pointer py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800">
                                        Change photo
                                    </label>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">JPG, PNG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                        <div class="mt-1">
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $employee->first_name) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('first_name') border-red-500 @enderror">
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                        <div class="mt-1">
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $employee->last_name) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('last_name') border-red-500 @enderror">
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="personal_num" class="block text-sm font-medium text-gray-700">Personal phone number</label>
                        <div class="mt-1">
                            <input type="text" name="personal_num" id="personal_num" value="{{ old('personal_num', $employee->personal_num) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('personal_num') border-red-500 @enderror">
                            @error('personal_num')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <div class="mt-1">
                            <input type="text" name="address" id="address" value="{{ old('address', $employee->address) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('address') border-red-500 @enderror">
                            @error('address')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Account Settings</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Update your password and security settings.</p>
            </div>

            <div class="px-4 py-5 sm:p-6 border-t border-gray-200">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current password</label>
                        <div class="mt-1">
                            <input type="password" name="current_password" id="current_password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="new_password" class="block text-sm font-medium text-gray-700">New password</label>
                        <div class="mt-1">
                            <input type="password" name="new_password" id="new_password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('new_password') border-red-500 @enderror">
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm new password</label>
                        <div class="mt-1">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>
            </div>

            @if(!$employee->is_freelancer)
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Professional Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Update your work-related information.</p>
            </div>

            <div class="px-4 py-5 sm:p-6 border-t border-gray-200">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="professional_email" class="block text-sm font-medium text-gray-700">Professional email</label>
                        <div class="mt-1">
                            <input type="email" name="professional_email" id="professional_email" value="{{ old('professional_email', $employee->professional_email) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('professional_email') border-red-500 @enderror">
                            @error('professional_email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="professional_num" class="block text-sm font-medium text-gray-700">Professional phone</label>
                        <div class="mt-1">
                            <input type="text" name="professional_num" id="professional_num" value="{{ old('professional_num', $employee->professional_num) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('professional_num') border-red-500 @enderror">
                            @error('professional_num')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
