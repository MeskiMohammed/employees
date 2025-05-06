@extends('layout.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-base-content">Dashboard</h1>
    <p class="mt-1 text-sm text-base-content">Welcome to your admin dashboard.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 mb-8 ">
    <!-- Total Employees -->
    <div class="bg-base-200  overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium  text-base-content truncate">Total Employees</dt>
                        <dd>
                            <div class="text-lg font-medium text-base-content">{{ $totalEmployees }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class=" px-4 py-4 sm:px-6 bg-base-300">
            <div class="text-sm">
                <a href="{{ route('employees.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">View all<span class="sr-only"> employees</span></a>
            </div>
        </div>
    </div>

    <!-- Total Departments -->
    <div class="bg-base-200 overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-base-content truncate">Total Departments</dt>
                        <dd>
                            <div class="text-lg font-medium text-base-content">{{ $totalDepartments }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class=" px-4 py-4 sm:px-6 bg-base-300">
            <div class="text-sm">
                <a href="{{ route('departments.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500 ">View all<span class="sr-only"> departments</span></a>
            </div>
        </div>
    </div>

</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 gap-5 lg:grid-cols-2 mb-8">
    <!-- Department Employees Chart -->
    <div class="bg-base-200 overflow-hidden lg:col-span-2 shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-base-content">Employees by Department</h3>
            <div class="mt-4 h-80">
                <canvas id="departmentEmployeesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Payments Chart -->
    <div class="bg-base-200 overflow-hidden shadow rounded-lg mb-8">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-base-content">Employees To Pay Soon</h3>
            <p class="mt-1 max-w-2xl text-sm text-base-content">Employees who need to be paid in 2 days.</p>
        </div>
        <div class="border-t border-base-300">
            <div class="overflow-hidden overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-base-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Employee</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Salary</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Payment Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-base-200 divide-y divide-base-300">
                        @if($employeesToPay->count() > 0)
                        @foreach($employeesToPay as $employee)
                        <tr>
                            <td class="py-4 px-2 whitespace-nowrap">
                                <a href='{{route('employees.show',$employee)}}' class='block cursor-pointer'>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $employee->profile_picture) }}" alt="{{ $employee->user->first_name }} {{ $employee->user->last_name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-base-content">{{ $employee->user->first_name }} {{ $employee->user->last_name }}</div>
                                        <div class="text-sm text-base-content opacity-70">{{ $employee->cin }}</div>
                                    </div>
                                </div>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-base-content">{{ number_format($employee->salary, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-base-content">{{ $employee->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('payments.create', ['employee_id' => $employee->id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Create Payment</a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-base-content">
                                No employees need to be paid in the next 2 days.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-4 py-4 sm:px-6 bg-base-200">
            <div class="text-sm">
                <a href="{{ route('payments.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">View all payments</a>
            </div>
        </div>
    </div>

    <!-- Recent Leaves -->
    <div class="bg-base-200 overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-base-content">Recent Leaves</h3>
            <p class="mt-1 max-w-2xl text-sm text-base-content">Latest leave requests.</p>
        </div>
        <div class="border-t border-base-300 ">
            <div class="overflow-hidden overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 ">
                    <thead class="bg-base-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Employee</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Reason</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">From</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">To</th>
                        </tr>
                    </thead>
                    <tbody class="bg-base-200 divide-y divide-base-300">
                        @foreach($recentLeaves as $leave)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-base-content">{{ $leave->employee->user->first_name }} {{ $leave->employee->user->last_name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-base-content">{{ $leave->reason->reason }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-base-content">{{ $leave->start_date->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-base-content">{{ $leave->end_date->format('M d, Y') }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class=" px-4 py-4 sm:px-6 bg-base-200">
            <div class="text-sm">
                <a href="{{ route('leaves.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">View all leaves</a>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Department Employees Chart
        const departmentCtx = document.getElementById('departmentEmployeesChart').getContext('2d');
        const departmentData = @json($departmentEmployees);

        new Chart(departmentCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(departmentData),
                datasets: [{
                    label: 'Number of Employees',
                    data: Object.values(departmentData),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

    });
</script>

@endpush
