@extends('layout.app')

@section('title', 'Edit Profile')

@section('header', 'Edit Profile')

@section('content')
    @if(session('success'))
        <x-toast></x-toast>
    @endif

    <div class="bg-base-200 shadow rounded-lg">
        <div class="p-6 border-b border-base-300">
            <div class=" px-4 sm:px-6 lg:px-8 py-6 ">
                <h1 class="text-2xl font-bold text-base-content">Edit Your Profile</h1>
                <p class="mt-1 text-sm text-base-content">Update your account information and settings.</p>

                <div class="px-4 py-5 sm:px-6 border-b border-base-300">
                    <h3 class="text-lg leading-6 font-medium text-base-content">Personal Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-base-content">Update your personal details.</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="first_name" class="block text-sm text-base-content font-medium">First
                                    Name</label>
                                <div class="mt-1">
                                    <input type="text" name="first_name" id="first_name"
                                        value="{{ old('first_name', auth()->user()->first_name) }}"
                                        class="shadow-sm bg-base-100 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('first_name') border-red-500 @enderror">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="last_name" class="block text-sm text-base-content font-medium">Last Name</label>
                                <div class="mt-1">
                                    <input type="text" name="last_name" id="last_name"
                                        value="{{ old('last_name', auth()->user()->last_name) }}"
                                        class="shadow-sm bg-base-100 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('last_name') border-red-500 @enderror">
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm text-base-content font-medium">Email address</label>
                                <div class="mt-1">
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        class="shadow-sm bg-base-100 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-5 sm:px-6 border-t border-base-200">
                        <h3 class="text-lg leading-6 font-medium text-base-content">Change Password</h3>
                        <p class="mt-1 max-w-2xl text-sm text-base-content">Update your password.</p>
                    </div>

                    <div class="px-4 py-5 sm:p-6 border-t border-base-300 text-base-content">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="current_password" class="block text-sm text-base-content font-medium">Current
                                    password</label>
                                <div class="mt-1">
                                    <input type="password" name="current_password" id="current_password"
                                        class="shadow-sm bg-base-100 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('current_password') border-red-500 @enderror">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="password" class="block text-sm text-base-content font-medium">New
                                    password</label>
                                <div class="mt-1">
                                    <input type="password" name="password" id="password"
                                        class="shadow-sm bg-base-100 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="password_confirmation"
                                    class="block text-sm text-base-content font-medium">Confirm new password</label>
                                <div class="mt-1">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="shadow-sm bg-base-100 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-base-200 text-right sm:px-6">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection