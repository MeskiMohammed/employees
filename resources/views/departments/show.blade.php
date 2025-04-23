@extends('layout.app')

@section('title', 'Department Details')

@section('header', 'Department Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('departments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Departments
        </a>
        <div>
            <a href="{{ route('departments.edit', $department) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this department?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Department Information</h2>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <p class="text-sm text-gray-500">Department Name</p>
                <p class="text-lg font-medium text-gray-900">{{ $department->name }}</p>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Description</p>
                <p class="text-base text-gray-900">{{ $department->description ?? 'No description provided.' }}</p>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Created At</p>
                <p class="text-base text-gray-900">{{ $department->created_at->format('F d, Y h:i A') }}</p>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Updated At</p>
                <p class="text-base text-gray-900">{{ $department->updated_at->format('F d, Y h:i A') }}</p>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Employees in this Department</h3>
                
                @if($department->employees->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($department->employees as $employee)
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
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $employee->status ? ($employee->status->status === 'active' ? 'green' : 'red') : 'gray' }}-100 text-{{ $employee->status ? ($employee->status->status === 'active' ? 'green' : 'red') : 'gray' }}-800">
                                            {{ $employee->status->status ?? 'N/A' }}
                                        </span>
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
                    <p class="text-gray-500">No employees found in this department.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
