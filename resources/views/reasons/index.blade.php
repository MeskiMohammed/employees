@extends('layout.app')

@section('title', 'Reasons')

@section('header', 'Reasons')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-base-content">Reasons</h1>
        <a href="{{ route('reasons.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add New Reason
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-base-200 shadow overflow-hidden sm:rounded-lg">
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

                        <a href="{{ route('reasons.edit', $reason) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('reasons.destroy',$reason) }}" method="POST" class="inline-block">
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
