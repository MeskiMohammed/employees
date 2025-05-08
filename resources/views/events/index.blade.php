@extends('layout.app')

@section('content')
    <div class="bg-base-200 border border-base-300 shadow rounded-lg">
        <div class="flex justify-between items-center p-6 border-base-300 border-b">
            <h2 class="text-xl font-semibold text-base-content">Events History</h2>
        </div>
        <div class="p-6 border-base-300 border-b bg-base-200">
            <form action="{{ route('events.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-base-content mb-1">Date</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md bg-base-100">
                </div>

                <div>
                    <label for="action" class="block text-sm font-medium  mb-1 text-base-content">Action</label>
                    <select name="action" id="action" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md bg-base-100">
                        <option value="">All Actions</option>
                        <option value="created" {{ request('action') == "created" ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('action') == "updated" ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('action') == "deleted" ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                    <a href="{{ route('events.index') }}"
                        class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-times mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto text-sm">
            <table class="min-w-full divide-y divide-base-300 ">
                <thead class="bg-base-200 ">

                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">
                            Date & Time</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">
                            User</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">
                            Resource Type
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">
                            Description</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">
                            IP Address</th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-base-300 bg-base-200 ">
                    @forelse($events as $event)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-base-content">{{ $event->created_at->format('Y-m-d H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($event->user)
                                    {{ $event->user->first_name }} {{ $event->user->last_name }} (ID:{{$event->user->id}})
                                @else
                                    System
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $event->model_type ? class_basename($event->model_type) : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $event->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $event->ip_address }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-base-content">
                                No Event history found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-base-300">
            {{ $events->withQueryString()->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection