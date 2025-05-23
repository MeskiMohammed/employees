@extends('layout.app')

@section('title', 'Create Reason')

@section('header', 'Create Reason')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-base-200 shadow rounded-lg">
            <div class="p-6 border-b border-base-300">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-base-content">Create New Reason</h1>
                    <a href="{{ route('reasons.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Back to List
                    </a>
                </div>

                <div class="bg-base-200 shadow overflow-hidden sm:rounded-lg">
                    <form action="{{ route('reasons.store') }}" method="POST">
                        @csrf
                        <div class="px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="reason" class="block text-sm font-medium text-base-content">Reason</label>
                                    <input type="text" name="reason" id="reason" value="{{ old('reason') }}"
                                        class="bg-base-100 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-base-300 rounded-md @error('reason') border-red-500 @enderror">
                                    @error('reason')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-base-200 text-right sm:px-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Reason
                            </button>
                        </div>
                    </form>
                </div>
            </div>
@endsection