@extends('layout.app')

@section('title', 'Employees')

@section('header', 'Employees')

@section('content')
<div class="bg-base-200 shadow rounded-lg">
    <div class="flex justify-between items-center p-6 border-b">
        <h2 class="text-xl font-semibold text-base-content">Employees List</h2>
        <a href="{{ route('employees.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-plus mr-2"></i> Add Employee
        </a>
    </div>
    
    <div class="p-6 border-b bg-base-200">
        <form action="{{ route('employees.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-base-content mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-base-100" placeholder="Search employees...">
            </div>
            
            <div>
                <label for="department" class="block text-sm font-medium text-base-content mb-1">Department</label>
                <select name="department" id="department" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-base-100">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium  mb-1 text-base-content">Status</label>
                <select name="status" id="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-base-100">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>{{ $status->status }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                <a href="{{ route('employees.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 ">
            <thead class="bg-base-100 ">
        
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Employee</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Departments</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Contact</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-base-content uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class=" divide-y divide-gray-200 bg-base-100 ">
                @forelse($employees as $employee)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap  ">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($employee->profile_picture)
                                    <img class="h-10 w-10 rounded-full" src="{{ Storage::url($employee->profile_picture) }}" alt="">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-base-content">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-base-content">
                                    {{ $employee->user->first_name .' '. $employee->user->last_name  ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-base-content">
                                    {{ $employee->cin }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">
                            @foreach ($employee->employeeDepartments as $dep)
                                @if ($loop->last)
                                    {{$dep->department->name}}
                                @else
                                    {{$dep->department->name}},
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">{{ $employee->professional_email ?? 'N/A' }}</div>
                        <div class="text-sm text-base-content">{{ $employee->professional_num ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $employee->status ? ($employee->status->status === 'active' ? 'green' : 'red') : 'gray' }}-100 text-{{ $employee->status ? ($employee->status->status === 'active' ? 'green' : 'red') : 'gray' }}-800">
                            {{ $employee->status->status ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('employees.show', $employee) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('employees.edit', $employee) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this employee?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-base-content">
                        No employees found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t">
        {{ $employees->withQueryString()->links() }}
    </div>
</div>
@endsection
