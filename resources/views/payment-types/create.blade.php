@extends('layout.app')

@section('title', 'Create Payment Type')

@section('header', 'Create Payment Type')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-base-200 shadow rounded-lg">
        <div class="p-6 border-b border-base-300">
            <h2 class="text-xl font-semibold text-base-content">Create New Payment Type</h2>
        </div>
        
        <form action="{{ route('payment-types.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-base-content mb-1">Payment Type</label>
                <input type="text" name="type" id="type" value="{{ old('type') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('type') border-red-500 @enderror" required>
                @error('type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('payment-types.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Payment Type
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
