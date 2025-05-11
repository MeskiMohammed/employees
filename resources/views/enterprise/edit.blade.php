@extends('layout.app')

@section('title', 'Edit Enterprise')

@section('header', 'Edit Enterprise')

@section('content')
    @if(session('success'))
        <x-toast></x-toast>
    @endif


    <div class="bg-base-200 shadow rounded-lg">
        <div class="flex justify-between items-center p-6 border-b border-base-300">
            <h1 class="text-xl font-semibold text-base-content">Edit Enterprise Information</h1>
            <a href="{{ route('dashboard') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 button-white">
                Back to Dashboard
            </a>

        </div>
            <form action="{{ route('enterprise.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class=" block text-sm font-medium text-base-content">Enterprise Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $enterprise->name) }}"
                                class=" bg-base-100 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-base-300 rounded-md @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="logo" class="block text-sm font-medium text-base-content">Enterprise Logo</label>
                            <div class="mt-2 flex items-center">
                                @if($enterprise->logo)
                                    <div class="mr-4">
                                        <img src="{{ asset('storage/' . $enterprise->logo) }}" alt="{{ $enterprise->name }}"
                                            class="h-16 w-auto object-contain">
                                    </div>
                                @endif
                                <input type="file" name="logo" id="logo"
                                    class="file-input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-base-300 rounded-md @error('logo') border-red-500 @enderror">
                            </div>
                            <p class="mt-1 text-sm text-base-content">Recommended size: 200x200 pixels. JPG, PNG or GIF.</p>
                            @error('logo')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="logo" class="block text-sm font-medium text-base-content">Enterprise Document Template</label>
                            <div class="mt-2 flex items-center">
                                <input type="file" name="document_template" id="logo"
                                    class="file-input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-base-300 rounded-md @error('logo') border-red-500 @enderror">
                            </div>
                            <p class="mt-1 text-sm text-base-content">File Format: PDF.</p>
                            @error('document_template')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-base-200 text-right sm:px-6">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Enterprise
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection