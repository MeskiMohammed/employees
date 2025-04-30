@extends('layout.app')

@section('title', 'Create Department')

@section('header', 'Create Department')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-base-200 shadow rounded-lg">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-base-content">Create New Department</h2>
        </div>
        
        <form action="{{ route('departments.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-base-content mb-1">Department Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-base-content mb-1">Description</label>
                <textarea name="description" id="description" rows="4" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('departments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
