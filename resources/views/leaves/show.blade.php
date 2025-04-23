@extends('layout.app')

@section('title', 'Leave Details')

@section('header', 'Leave Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('leaves.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Leaves
        </a>
        <div>
            <a href="{{ route('leaves.edit', $leave) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this leave?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Leave Information</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Information</h3>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-16 w-16">
                            @if($leave->employee->profile_picture)
                                <img class="h-16 w-16 rounded-full" src="{{ Storage::url($leave->employee->profile_picture) }}" alt="">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">
                                {{ $leave->employee->user->full_name ?? 'N/A' }}
                            </h4>
                            <p class="text-sm text-gray-500">
                                {{ $leave->employee->employee_code }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $leave->employee->department->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('employees.show', $leave->employee) }}" class="text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-external-link-alt mr-1"></i> View Employee Details
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Leave Details</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($leave->status == 'approved')
                                bg-green-100 text-green-800
                            @elseif($leave->status == 'rejected')
                                bg-red-100 text-red-800
                            @else
                                bg-yellow-100 text-yellow-800
                            @endif
                        ">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Period</p>
                        <p class="text-base font-medium text-gray-900">{{ $leave->start_date->format('F d, Y') }} - {{ $leave->end_date->format('F d, Y') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="text-base font-medium text-gray-900">{{ $leave->start_date->diffInDays($leave->end_date) + 1 }} days</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="text-base font-medium text-gray-900">{{ $leave->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Reason</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-gray-700 whitespace-pre-line">{{ $leave->reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
