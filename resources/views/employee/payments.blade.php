@extends('layout.employee')

@section('title', 'Payments')

@section('header', 'My Payments')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700">Payment History</h2>
    </div>
    
    <div class="p-6">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                <div class="relative">
                    <select id="year-filter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="all">All Years</option>
                        <option value="2025" selected>2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                    </select>
                </div>
                
                <div class="relative">
                    <select id="month-filter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="all">All Months</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5" selected>May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                
               
            </div>
            
            <div class="relative">
                <input type="text" id="payment-search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm" placeholder="Search payments...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(count($payments) > 0)
                        @foreach($payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $payment->date->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $payment->date->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $payment->description }}</div>
                                    <div class="text-sm text-gray-500">Ref: {{ $payment->reference_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $payment->type }}</div>
                                    <div class="text-sm text-gray-500">{{ $payment->payment_method }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">${{ number_format($payment->amount, 2) }}</div>
                                    @if($payment->tax_amount)
                                        <div class="text-xs text-gray-500">Tax: ${{ number_format($payment->tax_amount, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($payment->status == 'Paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Paid
                                        </span>
                                    @elseif($payment->status == 'Processing')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Processing
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $payment->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('employee.payments.download', $payment->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                        <button class="text-gray-600 hover:text-gray-900 view-payment" data-id="{{ $payment->id }}">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No payments found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>



@endsection

@section('scripts')
<script>
    // Payment search functionality
    const searchInput = document.getElementById('payment-search');
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const description = row.querySelector('td:nth-child(2) .text-gray-900').textContent.toLowerCase();
            const reference = row.querySelector('td:nth-child(2) .text-gray-500').textContent.toLowerCase();
            const type = row.querySelector('td:nth-child(3) .text-gray-900').textContent.toLowerCase();
            
            if (description.includes(searchTerm) || reference.includes(searchTerm) || type.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Year filter
    const yearFilter = document.getElementById('year-filter');
    yearFilter.addEventListener('change', filterPayments);
    
    // Month filter
    const monthFilter = document.getElementById('month-filter');
    monthFilter.addEventListener('change', filterPayments);
    
    // Type filter
    const typeFilter = document.getElementById('type-filter');
    typeFilter.addEventListener('change', filterPayments);
    
    function filterPayments() {
        const year = yearFilter.value;
        const month = monthFilter.value;
        const type = typeFilter.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const date = row.querySelector('td:first-child .text-gray-900').textContent;
            const paymentType = row.querySelector('td:nth-child(3) .text-gray-900').textContent;
            
            const rowDate = new Date(date);
            const rowYear = rowDate.getFullYear().toString();
            const rowMonth = (rowDate.getMonth() + 1).toString();
            
            const yearMatch = year === 'all' || rowYear === year;
            const monthMatch = month === 'all' || rowMonth === month;
            const typeMatch = type === 'all' || paymentType === type;
            
            if (yearMatch && monthMatch && typeMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Payment details modal
    const paymentDetailsModal = document.getElementById('payment-details-modal');
    const closePaymentDetailsBtn = document.getElementById('close-payment-details');
    
    document.querySelectorAll('.view-payment').forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.getAttribute('data-id');
            
            // In a real application, you would fetch the payment details from the server
            // For this example, we'll just show some mock data
            const paymentDetails = {
                id: paymentId,
                date: '2025-05-01',
                description: 'Monthly Salary - May 2025',
                reference_number: 'PAY-2025-05-001',
                type: 'Salary',
                payment_method: 'Direct Deposit',
                amount: 5000.00,
                tax_amount: 1250.00,
                net_amount: 3750.00,
                status: 'Paid',
                account_number: '****1234',
                bank_name: 'Example Bank',
                notes: 'Regular monthly salary payment'
            };
            
            const content = document.getElementById('payment-details-content');
            content.innerHTML = `
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Payment Date</p>
                            <p class="text-sm text-gray-900">${new Date(paymentDetails.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                ${paymentDetails.status}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="border-b border-gray-200 pb-4">
                    <p class="text-sm font-medium text-gray-500">Description</p>
                    <p class="text-sm text-gray-900">${paymentDetails.description}</p>
                    <p class="text-sm text-gray-500 mt-1">Reference: ${paymentDetails.reference_number}</p>
                </div>
                
                <div class="border-b border-gray-200 pb-4">
                    <p class="text-sm font-medium text-gray-500">Payment Details</p>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-500">Type</p>
                            <p class="text-sm text-gray-900">${paymentDetails.type}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-500">Method</p>
                            <p class="text-sm text-gray-900">${paymentDetails.payment_method}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-500">Bank</p>
                            <p class="text-sm text-gray-900">${paymentDetails.bank_name}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-500">Account</p>
                            <p class="text-sm text-gray-900">${paymentDetails.account_number}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <p class="text-sm font-medium text-gray-500">Amount</p>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-500">Gross Amount</p>
                            <p class="text-sm text-gray-900">$${paymentDetails.amount.toFixed(2)}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-500">Tax</p>
                            <p class="text-sm text-gray-900">$${paymentDetails.tax_amount.toFixed(2)}</p>
                        </div>
                        <div class="flex justify-between font-medium">
                            <p class="text-sm text-gray-500">Net Amount</p>
                            <p class="text-sm text-gray-900">$${paymentDetails.net_amount.toFixed(2)}</p>
                        </div>
                    </div>
                </div>
            `;
            
            paymentDetailsModal.classList.remove('hidden');
        });
    });
    
    closePaymentDetailsBtn.addEventListener('click', function() {
        paymentDetailsModal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === paymentDetailsModal) {
            paymentDetailsModal.classList.add('hidden');
        }
    });
    
    // Earnings chart
    const ctx = document.getElementById('earnings-chart').getContext('2d');
    const earningsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Gross Earnings',
                data: [4800, 4800, 5200, 4800, 5000, 0, 0, 0, 0, 0, 0, 0],
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1
            }, {
                label: 'Net Earnings',
                data: [3600, 3600, 3900, 3600, 3750, 0, 0, 0, 0, 0, 0, 0],
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount ($)'
                    }
                }
            }
        }
    });
</script>
@endsection
