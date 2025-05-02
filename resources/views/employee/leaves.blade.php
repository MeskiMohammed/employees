@extends('layout.employee')

@section('title', 'Request Leave')

@section('header', 'Request Leave')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700">New Leave Request</h2>
        <p class="mt-1 text-sm text-gray-500">Please fill out the form below to submit your leave request.</p>
    </div>
    <div class="p-6">
        <form action="{{ route('employee.leaves.store') }}" method="POST">
            @csrf
            
            @if ($errors->any())
                <div class="mb-4 bg-red-50 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="leave_type" class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                    <select id="leave_type" name="leave_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="">Select a leave type</option>
                        <option value="annual">Annual Leave</option>
                        <option value="sick">Sick Leave</option>
                        <option value="personal">Personal Leave</option>
                        <option value="bereavement">Bereavement Leave</option>
                        <option value="maternity">Maternity Leave</option>
                        <option value="paternity">Paternity Leave</option>
                        <option value="unpaid">Unpaid Leave</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="hidden" id="other_leave_type_container">
                    <label for="other_leave_type" class="block text-sm font-medium text-gray-700 mb-1">Specify Leave Type</label>
                    <input type="text" name="other_leave_type" id="other_leave_type" class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (Days)</label>
                    <input type="number" name="duration" id="duration" readonly class="mt-1 bg-gray-50 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="half_day" class="block text-sm font-medium text-gray-700 mb-1">Half Day</label>
                    <select id="half_day" name="half_day" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="no">No</option>
                        <option value="first_day_morning">First Day Morning</option>
                        <option value="first_day_afternoon">First Day Afternoon</option>
                        <option value="last_day_morning">Last Day Morning</option>
                        <option value="last_day_afternoon">Last Day Afternoon</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                    <textarea id="reason" name="reason" rows="3" class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    <p class="mt-1 text-sm text-gray-500">Please provide a brief explanation for your leave request.</p>
                </div>
                
                <div class="md:col-span-2">
                    <label for="contact_details" class="block text-sm font-medium text-gray-700 mb-1">Contact Details During Leave</label>
                    <input type="text" name="contact_details" id="contact_details" class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-1 text-sm text-gray-500">How can we reach you during your leave if needed?</p>
                </div>
                
                <div class="md:col-span-2">
                    <label for="handover_instructions" class="block text-sm font-medium text-gray-700 mb-1">Handover Instructions</label>
                    <textarea id="handover_instructions" name="handover_instructions" rows="3" class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    <p class="mt-1 text-sm text-gray-500">Please provide any handover instructions or pending tasks.</p>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end">
                    <a href="{{ route('employee.leaves') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Cancel
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Submit Request
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700">Leave Balance</h2>
        <p class="mt-1 text-sm text-gray-500">Your current leave balance for the year {{ date('Y') }}</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Annual Leave</h3>
                <div class="mt-2 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">{{ $leaveBalance->annual ?? 0 }}</span>
                    <span class="ml-1 text-sm text-gray-500">/ {{ $leaveBalance->annual_total ?? 0 }} days</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $leaveBalance->annual_percentage ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Sick Leave</h3>
                <div class="mt-2 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">{{ $leaveBalance->sick ?? 0 }}</span>
                    <span class="ml-1 text-sm text-gray-500">/ {{ $leaveBalance->sick_total ?? 0 }} days</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $leaveBalance->sick_percentage ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Personal Leave</h3>
                <div class="mt-2 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">{{ $leaveBalance->personal ?? 0 }}</span>
                    <span class="ml-1 text-sm text-gray-500">/ {{ $leaveBalance->personal_total ?? 0 }} days</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $leaveBalance->personal_percentage ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700">Leave Policy</h2>
    </div>
    <div class="p-6">
        <div class="prose max-w-none">
            <h3>Annual Leave</h3>
            <p>Full-time employees are entitled to 21 days of annual leave per year. Annual leave accrues progressively throughout the year and is credited on a monthly basis.</p>
            
            <h3>Sick Leave</h3>
            <p>Full-time employees are entitled to 10 days of paid sick leave per year. A medical certificate is required for sick leave exceeding 2 consecutive days.</p>
            
            <h3>Personal Leave</h3>
            <p>Full-time employees are entitled to 3 days of personal leave per year for personal matters such as moving house or attending to family responsibilities.</p>
            
            <h3>Maternity Leave</h3>
            <p>Female employees are entitled to 14 weeks of paid maternity leave after completing one year of continuous service.</p>
            
            <h3>Paternity Leave</h3>
            <p>Male employees are entitled to 2 weeks of paid paternity leave after completing one year of continuous service.</p>
            
            <h3>Bereavement Leave</h3>
            <p>Employees are entitled to 3 days of paid bereavement leave in the event of the death of an immediate family member.</p>
            
            <h3>Unpaid Leave</h3>
            <p>Unpaid leave may be granted at the discretion of management. Approval is subject to operational requirements and the employee's leave record.</p>
            
            <h3>Leave Application Process</h3>
            <p>Leave applications should be submitted at least 2 weeks in advance for annual leave and as soon as practicable for other types of leave. Approval is subject to operational requirements and the employee's leave record.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Show/hide other leave type field
    const leaveTypeSelect = document.getElementById('leave_type');
    const otherLeaveTypeContainer = document.getElementById('other_leave_type_container');
    
    leaveTypeSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            otherLeaveTypeContainer.classList.remove('hidden');
        } else {
            otherLeaveTypeContainer.classList.add('hidden');
        }
    });
    
    // Calculate duration
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const durationInput = document.getElementById('duration');
    
    function calculateDuration() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (startDate && endDate && !isNaN(startDate) && !isNaN(endDate)) {
            // Calculate the difference in days
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include both start and end dates
            
            durationInput.value = diffDays;
        } else {
            durationInput.value = '';
        }
    }
    
    startDateInput.addEventListener('change', calculateDuration);
    endDateInput.addEventListener('change', calculateDuration);
</script>
@endsection
