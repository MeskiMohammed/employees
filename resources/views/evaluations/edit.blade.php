@extends('layout.app')

@section('title', 'Edit Evaluation')

@section('header', 'Edit Evaluation')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Edit Evaluation</h2>
        </div>
        
        <form action="{{ route('evaluations.update', $evaluation) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                    <select name="employee_id" id="employee_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('employee_id') border-red-500 @enderror" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $evaluation->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->user->full_name ?? 'N/A' }} ({{ $employee->employee_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Evaluation Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $evaluation->date->format('Y-m-d')) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('date') border-red-500 @enderror" required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="score" class="block text-sm font-medium text-gray-700 mb-1">Score (0-100)</label>
                    <input type="number" name="score" id="score" min="0" max="100" value="{{ old('score', $evaluation->score) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('score') border-red-500 @enderror" required>
                    @error('score')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('notes') border-red-500 @enderror">{{ old('notes', $evaluation->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('evaluations.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Evaluation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
