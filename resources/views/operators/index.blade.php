@extends('layout.app')

@section('title', 'Operators')

@section('header', 'Operators')

@section('content')
<div class="bg-base-200 shadow rounded-lg">
    <div class="flex justify-between items-center p-6 border-b border-base-300">
        <h2 class="text-xl font-semibold text-base-content">Operators List</h2>
        <a href="{{ route('operators.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-plus mr-2"></i> Add Operator
        </a>
    </div>

    <div class="p-6 border-b border-base-300">
        <form action="{{ route('operators.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-base-content mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md" placeholder="Search operators...">
            </div>

            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-search mr-2"></i> Search
                </button>
                <a href="{{ route('operators.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-base-300">
            <thead class="bg-base-200 ">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Operator</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Employees Count</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Created At</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-base-content uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-base-200  divide-y divide-base-300 ">
                @forelse($operators as $operator)
                <tr class="hover:bg-base-100">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">{{ $operator->id }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-base-content">{{ $operator->operator }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $operator->employees_count }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">{{ $operator->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-base-content">{{ $operator->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <!-- <a href="{{ route('operators.show', $operator) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a> -->
                        <a href="{{ route('operators.edit', $operator) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('operators.destroy', $operator) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this operator?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                        No operators found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-base-300">
        {{ $operators->withQueryString()->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
