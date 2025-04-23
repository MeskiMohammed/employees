@extends('layout.app')

@section('title', 'Create User Role')

@section('header', 'Create User Role')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Create New User Role</h2>
        </div>
        
        <form action="{{ route('user-roles.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                <input type="text" name="role" id="role" value="{{ old('role') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('role') border-red-500 @enderror" required>
                @error('role')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('user-roles.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create User Role
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
