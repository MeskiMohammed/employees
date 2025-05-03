@extends('layout.app')

@section('title', 'Leaves')

@section('header', 'Leaves')

@section('content')
<div class="bg-base-200 shadow rounded-lg">
    <div class="flex justify-between items-center p-6 border-b border-base-300">
        <h2 class="text-xl font-semibold text-base-content">Leaves List</h2>
    </div>

    <div class="p-6 border-b border-base-300">
        <form action="{{ route('leaves.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-base-content mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md" placeholder="Search leaves...">
            </div>

            <div>
                <label for="employee_id" class="block text-sm font-medium text-base-content mb-1">Employee</label>
                <select name="employee_id" id="employee_id" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->user->full_name ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-base-content mb-1">Status</label>
                <select name="status" id="status" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-base-content mb-1">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-base-content mb-1">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md">
            </div>

            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                <a href="{{ route('leaves.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class=" min-w-full divide-y divide-base-300 ">
            <thead class=" bg-base-200 ">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Employee</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Period</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Duration</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Reason</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-base-content uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-base-200 divide-y divide-base-300 ">
                @forelse($leaves as $leave)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 ">
                                @if($leave->employee->profile_picture)
                                <img class="h-10 w-10 rounded-full" src="{{ Storage::url($leave->employee->profile_picture) }}" alt="">
                                @else
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                    <i class="fas fa-user"></i>
                                </div>
                                @endif
                            </div>
                            <div class="ml-4 ">
                                <div class="text-sm font-medium text-base-content">
                                    {{ $leave->employee->user->first_name .' ' . $leave->employee->user->last_name ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-base-content">
                                    {{ $leave->employee->employee_code ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">{{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-base-content">{{ $leave->start_date->diffInDays($leave->end_date) + 1 }} days</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-base-content truncate max-w-xs">{{ $leave->reason->reason }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
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
                    </td>
                    <td class="px-6 flex justify-end items-center py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($leave->status === 'pending')
                        <a href="{{ route('leaves.update', ['leave' => $leave->id, 'status' => 'approved']) }}"
                            class="inline-block flex justify-center items-center text-green-600 font-medium mr-2 w-5 aspect-square bg-green-300 border rounded border-green-600"
                            onclick="return confirm('Confirmer l\'acceptation de ce congé ?')">
                            <i class="fa-solid fa-check"></i>
                        </a>

                        <a href="{{ route('leaves.update', ['leave' => $leave->id, 'status' => 'rejected']) }}"
                            class="inline-block flex justify-center items-center text-red-600 font-medium w-5 aspect-square bg-red-300 border rounded border-red-600"
                            onclick="return confirm('Confirmer l\'annulation de ce congé ?')">
                            <i class="fa-solid fa-x "></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                        No leaves found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-base-300 border-t">
        {{ $leaves->withQueryString()->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection