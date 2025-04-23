@extends('layout.app')

@section('title', 'User Details')

@section('header', 'User Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Users
        </a>
        <div>
            <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this user?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-24 w-24">
                    <img class="h-24 w-24 rounded-full" src="https://ui-avatars.com/api/?name={{ $user->first_name }}+{{ $user->last_name }}&background=random" alt="{{ $user->full_name }}">
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($user->status && $user->status->status == 'active')
                                bg-green-100 text-green-800
                            @elseif($user->status && $user->status->status == 'inactive')
                                bg-red-100 text-red-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif
                        ">
                            {{ $user->status->status ?? 'N/A' }}
                        </span>
                        <span class="ml-2 text-sm text-gray-500">{{ $user->role->role ?? 'No Role' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Information</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">First Name</p>
                        <p class="text-base font-medium text-gray-900">{{ $user->first_name }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Last Name</p>
                        <p class="text-base font-medium text-gray-900">{{ $user->last_name }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-base font-medium text-gray-900">{{ $user->email }}</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Role</p>
                        <p class="text-base font-medium text-gray-900">{{ $user->role->role ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($user->status && $user->status->status == 'active')
                                bg-green-100 text-green-800
                            @elseif($user->status && $user->status->status == 'inactive')
                                bg-red-100 text-red-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif
                        ">
                            {{ $user->status->status ?? 'N/A' }}
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="text-base font-medium text-gray-900">{{ $user->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Email Verified At</p>
                        <p class="text-base font-medium text-gray-900">{{ $user->email_verified_at ? $user->email_verified_at->format('F d, Y h:i A') : 'Not verified' }}</p>
                    </div>
                </div>
            </div>
            
            @if($user->employee)
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Information</h3>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16">
                            @if($user->employee->profile_picture)
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ Storage::url($user->employee->profile_picture) }}" alt="{{ $user->full_name }}">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <p class="text-base font-medium text-gray-900">Employee Code: {{ $user->employee->employee_code }}</p>
                            <p class="text-sm text-gray-500">Department: {{ $user->employee->department->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">Status: {{ $user->employee->status->status ?? 'N/A' }}</p>
                            <a href="{{ route('employees.show', $user->employee) }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-external-link-alt mr-1"></i> View Employee Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
