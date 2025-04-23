@extends('layout.app')

@section('title', 'Edit Status')

@section('header', 'Edit Status')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Edit Status</h2>
        </div>
        
        <form action="{{ route('statuses.update', $status) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Name</label>
                <input type="text" name="status" id="status" value="{{ old('status', $status->status) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('status') border-red-500 @enderror" required>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('statuses.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
