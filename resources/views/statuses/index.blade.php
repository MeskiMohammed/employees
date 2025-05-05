@extends('layout.app')

@section('title', 'Statuses')

@section('header', 'Statuses')

@section('content')
<div class="bg-base-200 shadow rounded-lg">
    <div class="flex justify-between items-center p-6 border-b border-base-300">
        <h2 class="text-xl font-semibold text-base-content">Statuses List</h2>
        @if (Auth::user()->can('create statuses'))
        <a href="{{ route('statuses.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-plus mr-2"></i> Add Status
        </a>
        @endif
    </div>

    <div class="p-6 border-b border-base-300">
        <form action="{{ route('statuses.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-base-content mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md" placeholder="Search statuses...">
            </div>

            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-search mr-2"></i> Search
                </button>
                <a href="{{ route('statuses.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="min-w-full divide-y divide-base-200">
            <thead class="bg-base-200">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Employees Count</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Created At</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-base-content uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-base-200 divide-y divide-base-200">
                @forelse($statuses as $status)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">{{ $status->id }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                            {{ $status->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">{{ $status->employees_count }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">{{ $status->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-base-content">{{ $status->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if(Auth::user()->can('edit statuses'))
                        <a href="{{ route('statuses.edit', $status) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        @if(Auth::user()->can('delete statuses'))
                        <form action="{{ route('statuses.destroy', $status) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this status?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                        No statuses found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-base-300">
        {{ $statuses->withQueryString()->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
