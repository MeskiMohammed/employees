@extends('layout.app')

@section('title', 'Create Freelancer Project')

@section('header', 'Create Freelancer Project')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-base-200  shadow rounded-lg">
        <div class="p-6 border-b border-base-300">
            <h2 class="text-xl font-semibold text-base-content">Create New Freelancer Project</h2>
        </div>
        
        <form action="{{ route('freelancer-projects.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-base-content mb-1">Project Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-base-content mb-1">Freelancer</label>
                    <select name="employee_id" id="employee_id" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('employee_id') border-red-500 @enderror" required>
                        <option value="">Select Freelancer</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->user->first_name . ' ' . $employee->user->last_name }} ({{ $employee->cin }})
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="price" class="block text-sm font-medium text-base-content mb-1">Price</label>
                    <input type="number" name="price" id="price" min="0" step="0.01" value="{{ old('price') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('price') border-red-500 @enderror" required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('freelancer-projects.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
