@extends('layout.app')

@section('title', 'Status Details')

@section('header', 'Status Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('statuses.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Statuses
        </a>
        <div>
            <a href="{{ route('statuses.edit', $status) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('statuses.destroy', $status) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this status?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Status Information</h2>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <p class="text-sm text-gray-500">Status</p>
                <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @if($status->status == 'active')
                        bg-green-100 text-green-800
                    @elseif($status->status == 'inactive')
                        bg-red-100 text-red-800
                    @else
                        bg-gray-100 text-gray-800
                    @endif
                ">
                    {{ $status->status }}
                </span>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Created At</p>
                <p class="text-base text-gray-900">{{ $status->created_at->format('F d, Y h:i A') }}</p>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Updated At</p>
                <p class="text-base text-gray-900">{{ $status->updated_at->format('F d, Y h:i A') }}</p>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Employees with this Status</h3>
                
                @if($status->employees->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($status->employees as $employee)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($employee->profile_picture)
                                                    <img class="h-10 w-10 rounded-full" src="{{ Storage::url($employee->profile_picture) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $employee->user->full_name ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $employee->employee_code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $employee->department->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('employees.show', $employee) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No employees found with this status.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
