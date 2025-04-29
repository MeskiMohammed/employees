@extends('layout.app')

@section('title', 'Edit Enterprise')

@section('header', 'Edit Enterprise')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Enterprise Information</h1>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
          Back to Dashboard
        </a>

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
        <form action="{{ route('enterprise.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Enterprise Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $enterprise->name) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700">Enterprise Logo</label>
                        <div class="mt-2 flex items-center">
                            @if($enterprise->logo)
                                <div class="mr-4">
                                    <img src="{{ asset('storage/' . $enterprise->logo) }}" alt="{{ $enterprise->name }}" class="h-16 w-auto object-contain">
                                </div>
                            @endif
                            <input type="file" name="logo" id="logo" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md @error('logo') border-red-500 @enderror">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Recommended size: 200x200 pixels. JPG, PNG or GIF.</p>
                        @error('logo')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Enterprise
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
