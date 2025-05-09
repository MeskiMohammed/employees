@extends('layout.app')

@section('title', 'Edit Operator')

@section('header', 'Edit Operator')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-base-200 shadow rounded-lg">
        <div class="p-6 ">
            <h2 class="text-xl font-semibold  text-base-content">Edit Operator</h2>
        </div>

        <form action="{{ route('operators.update', $operator) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="operator" class="block text-sm font-medium  text-base-content mb-1">Operator Name</label>
                <input type="text" name="operator" id="operator" value="{{ old('operator', $operator->operator) }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm  rounded-md @error('operator') border-red-500 @enderror" required>
                @error('operator')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('operators.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 button-white mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Operator
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
