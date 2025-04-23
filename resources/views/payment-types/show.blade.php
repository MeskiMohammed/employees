@extends('layout.app')

@section('title', 'Payment Type Details')

@section('header', 'Payment Type Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('payment-types.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Payment Types
        </a>
        <div>
            <a href="{{ route('payment-types.edit', $paymentType) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('payment-types.destroy', $paymentType) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this payment type?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Payment Type Information</h2>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <p class="text-sm text-gray-500">Type</p>
                <p class="text-lg font-medium text-gray-900">{{ $paymentType->type }}</p>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Created At</p>
                <p class="text-base text-gray-900">{{ $paymentType->created_at->format('F d, Y h:i A') }}</p>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Updated At</p>
                <p class="text-base text-gray-900">{{ $paymentType->updated_at->format('F d, Y h:i A') }}</p>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Related Payments</h3>
                
                @if($paymentType->payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($paymentType->payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $payment->employee->user->full_name ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $payment->employee->employee_code ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $payment->date->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ number_format($payment->net, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No payments found for this payment type.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
