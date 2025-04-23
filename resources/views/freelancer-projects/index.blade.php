@extends('layout.app')

@section('title', 'Freelancer Projects')

@section('header', 'Freelancer Projects')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="flex justify-between items-center p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Freelancer Projects List</h2>
        <a href="{{ route('freelancer-projects.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-plus mr-2"></i> Add Project
        </a>
    </div>
    
    <div class="p-6 border-b">
        <form action="{{ route('freelancer-projects.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search projects...">
            </div>
            
            <div>
                <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                <select name="employee_id" id="employee_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->user->full_name ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="price_min" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                <input type="number" name="price_min" id="price_min" value="{{ request('price_min') }}" min="0" step="0.01" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Min price">
            </div>
            
            <div>
                <label for="price_max" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                <input type="number" name="price_max" id="price_max" value="{{ request('price_max') }}" min="0" step="0.01" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Max price">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                <a href="{{ route('freelancer-projects.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($projects as $project)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $project->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($project->employee->profile_picture)
                                    <img class="h-10 w-10 rounded-full" src="{{ Storage::url($project->employee->profile_picture) }}" alt="">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $project->employee->user->full_name ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $project->employee->employee_code ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ number_format($project->price, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $project->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $project->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('freelancer-projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('freelancer-projects.edit', $project) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('freelancer-projects.destroy', $project) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this project?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                        No freelancer projects found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t">
        {{ $projects->withQueryString()->links() }}
    </div>
</div>
@endsection
