@extends('layout.app')

@section('title', 'Create Payment for ' . $employee->user->first_name . ' ' . $employee->user->last_name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Create Payment for {{ $employee->user->first_name }} {{ $employee->user->last_name }}</h1>
        <a href="{{ route('employees.show', $employee->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Employee Page
        </a>
    </div>

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Employee Information Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center mb-4">
                @if($employee->profile_picture)
                <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="{{ $employee->user->first_name }}" class="w-16 h-16 rounded-full object-cover mr-4">
                @else
                <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                    <span class="text-xl text-gray-600">{{ substr($employee->user->first_name, 0, 1) }}{{ substr($employee->user->last_name, 0, 1) }}</span>
                </div>
                @endif
                <div>
                    <h2 class="text-xl font-semibold">{{ $employee->user->first_name }} {{ $employee->user->last_name }}</h2>
                    <p class="text-gray-600">{{ $employee->user->email }}</p>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">Employee ID</p>
                        <p class="font-medium">{{ $employee->cin ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Departments</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($employee->employeeDepartments as $department)
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $department->department->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Salary Calculation Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Salary Calculation</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Gross Salary</span>
                    <span class="font-medium">{{ number_format($grossSalary, 2) }} MAD</span>
                </div>
                
                <div class="flex justify-between items-center text-red-600">
                    <span>CNSS Deduction (6.74%)</span>
                    <span>- {{ number_format($cnssDeduction, 2) }} MAD</span>
                </div>
                
                <div class="flex justify-between items-center text-red-600">
                    <span>Income Tax ({{ $taxRate * 100 }}%)</span>
                    <span>- {{ number_format($incomeTaxDeduction, 2) }} MAD</span>
                </div>
                
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <div class="flex justify-between items-center font-bold">
                        <span>Net Salary</span>
                        <span class="text-green-600">{{ number_format($netSalary, 2) }} MAD</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Previous Payments Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Previous Payments</h2>
            
            @if($previousPayments->count() > 0)
            <div class="space-y-3">
                @foreach($previousPayments as $payment)
                <div class="border-b border-gray-200 pb-2 last:border-0">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">{{ $payment->payment_date->format('M d, Y') }}</span>
                        <span class="font-medium">{{ number_format($payment->amount, 2) }} MAD</span>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $payment->description ?? $payment->paymentType->name ?? 'Regular Payment' }}
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-4">No previous payments found</p>
            @endif
        </div>
    </div>

    <!-- Payment Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-6">Payment Details</h2>
        
        <form action="{{ route('employees.pay', $employee) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="payment_type_id" class="block text-sm font-medium text-gray-700 mb-1">Payment Type</label>
                    <select id="payment_type_id" name="payment_type_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('payment_type_id') border-red-500 @enderror">
                        <option value="">Select Payment Type</option>
                        @foreach($paymentTypes as $type)
                        <option value="{{ $type->id }}" {{ old('payment_type_id') == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                        @endforeach
                    </select>
                    @error('payment_type_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('employees.show', $employee->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                    Create Payment
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodSelect = document.getElementById('payment_method');
        const bankTransferFields = document.getElementById('bank_transfer_fields');
        const checkFields = document.getElementById('check_fields');
        
        function togglePaymentFields() {
            const selectedMethod = paymentMethodSelect.value;
            
            // Hide all fields first
            bankTransferFields.classList.add('hidden');
            checkFields.classList.add('hidden');
            
            // Show relevant fields based on selection
            if (selectedMethod === 'bank_transfer') {
                bankTransferFields.classList.remove('hidden');
            } else if (selectedMethod === 'check') {
                checkFields.classList.remove('hidden');
            }
        }
        
        // Initial toggle based on default value
        togglePaymentFields();
        
        // Add event listener for changes
        paymentMethodSelect.addEventListener('change', togglePaymentFields);
    });
</script>
@endsection
