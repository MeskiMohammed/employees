@extends('layout.app')

@section('title', 'Reasons')

@section('header', 'Reasons')

@section('content')
@if(session('success'))
        <x-toast></x-toast>
    @endif
    <div class="bg-base-200 shadow rounded-lg">
        <div class="flex justify-between items-center p-6 border-b border-base-300">
            <h2 class="text-xl font-semibold text-base-content">Reasons</h2>
            @if (Auth::user()->can('create statuses'))
            <a href="{{ route('reasons.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-plus mr-2"></i> Add New Reason
            </a>
            @endif
        </div>
    
        <div class="p-6 border-b border-base-300">
            <form action="{{ route('reasons.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-base-content mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md" placeholder="Search reasons...">
                </div>
    
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 button-white">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                    <a href="{{ route('reasons.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 button-white">
                        <i class="fas fa-times mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>

                
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-base-200">
                <thead class="bg-base-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Reason</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Created At</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-base-content uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-base-200 divide-y divide-base-200">
                    @forelse($reasons as $reason)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-base-content">{{ $reason->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-base-content">{{ $reason->reason }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-base-content">{{ $reason->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if (Auth::user()->can('create reasons'))
                        <a href="{{ route('reasons.edit', $reason) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        
                        @if (Auth::user()->can('delete reasons'))
                        <form action="{{ route('reasons.destroy',$reason) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this employee?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No reasons found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3  border-t border-base-300 sm:px-6 bg-base-200">
            {{ $reasons->links() }}
        </div>
    </div>


    <div class="px-6 py-4 border-t border-base-300">
        {{ $reasons->withQueryString()->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
