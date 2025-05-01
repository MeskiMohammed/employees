@extends('layout.app')

@section('title', 'Create Operator')

@section('header', 'Create Operator')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-base-200 shadow rounded-lg">
        <div class="p-6 border-b border-base-300">
            <h2 class="text-xl font-semibold text-base-content">Create New Operator</h2>
        </div>
        
        <form action="{{ route('operators.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label for="operator" class="block text-sm font-medium text-base-content mb-1">Operator Name</label>
                <input type="text" name="operator" id="operator" value="{{ old('operator') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('operator') border-red-500 @enderror" required>
                @error('operator')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('operators.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Operator
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
