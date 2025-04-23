@extends('layout.app')

@section('title', 'Edit Attachment')

@section('header', 'Edit Attachment')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Edit Attachment</h2>
        </div>
        
        <form action="{{ route('attachments.update', $attachment) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Attachment Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $attachment->name) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                    <select name="employee_id" id="employee_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('employee_id') border-red-500 @enderror" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $attachment->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->user->full_name ?? 'N/A' }} ({{ $employee->employee_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">File</label>
                    <div class="flex items-center mb-2">
                        <span class="text-sm text-gray-500 mr-2">Current file:</span>
                        <a href="{{ route('attachments.download', $attachment) }}" class="text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-download mr-1"></i> Download
                        </a>
                    </div>
                    <input type="file" name="attachment" id="attachment" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('attachment') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Max file size: 10MB. Leave empty to keep the current file.</p>
                    @error('attachment')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('attachments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Attachment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
