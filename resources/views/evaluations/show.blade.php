@extends('layout.app')

@section('title', 'Evaluation Details')

@section('header', 'Evaluation Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('evaluations.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Evaluations
        </a>
        <div>
            <a href="{{ route('evaluations.edit', $evaluation) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this evaluation?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Evaluation Information</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Information</h3>
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-16 w-16">
                            @if($evaluation->employee->profile_picture)
                                <img class="h-16 w-16 rounded-full" src="{{ Storage::url($evaluation->employee->profile_picture) }}" alt="">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">
                                {{ $evaluation->employee->user->full_name ?? 'N/A' }}
                            </h4>
                            <p class="text-sm text-gray-500">
                                {{ $evaluation->employee->employee_code }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $evaluation->employee->department->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Evaluation Details</h3>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Evaluation Date</p>
                        <p class="text-base font-medium text-gray-900">{{ $evaluation->date->format('F d, Y') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Score</p>
                        <div class="flex items-center">
                            <p class="text-xl font-bold 
                                @if($evaluation->score >= 80)
                                    text-green-600
                                @elseif($evaluation->score >= 60)
                                    text-yellow-600
                                @else
                                    text-red-600
                                @endif
                            ">
                                {{ $evaluation->score }}/100
                            </p>
                            <div class="ml-4 flex-1">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="
                                        @if($evaluation->score >= 80)
                                            bg-green-600
                                        @elseif($evaluation->score >= 60)
                                            bg-yellow-600
                                        @else
                                            bg-red-600
                                        @endif
                                        h-2.5 rounded-full" 
                                        style="width: {{ $evaluation->score }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-gray-700 whitespace-pre-line">{{ $evaluation->notes ?? 'No notes provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
