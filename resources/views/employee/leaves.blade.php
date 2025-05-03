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
        <form action="{{ route('leaves.store') }}" method="POST">
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



          
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="hidden" id="other_leave_type_container">
                    <label for="other_leave_type" class="block text-sm font-medium text-gray-700 mb-1">Specify Leave Type</label>
                    <input type="text" name="other_leave_type" id="other_leave_type" class="mt-1 focus:ring-emerald-500 focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 focus:ring-emerald-500  text-black focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-base-300 rounded-md">
                </div>
                
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 focus:ring-emerald-500  text-black focus:border-emerald-500 block w-full shadow-sm sm:text-sm border-base-300 rounded-md">
                </div>
                
                <div>
                    <label for="reason_id" class="block text-sm font-medium text-gray-700 mb-1">Reason Leaves</label>
                    <select id="reason_id" name="reason_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-black border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="">Select a Reason</option>
                        @foreach(\App\Models\Reason::all() as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                        @endforeach
                    </select>
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

<div class="font-semibold text-2xl text-black mb-6 mt-8">
            Leaves
          </div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700">  Recent Leaves</h2>
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
               
</div>



    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-gray-100 text-left text-sm uppercase text-gray-600">
                <th class="px-4 py-2">Date de début</th>
                <th class="px-4 py-2">Date de fin</th>
                <th class="px-4 py-2">Durée</th>
                <th class="px-4 py-2">Reason</th>
                <th class="px-4 py-2">Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employee->leaves as $leave)
            <tr class="border-t text-sm text-gray-700">
                <!-- <td class="px-4 py-2">{{ $loop->iteration }}</td> -->
                <td class="px-4 py-2">{{ $leave->start_date->format('d/m/Y') }}</td>
                <td class="px-4 py-2">{{ $leave->end_date->format('d/m/Y') }}</td>
                <td class="px-4 py-2">
                    {{ $leave->start_date->diffInDays($leave->end_date) + 1 }} jours
                </td>
                <td class="px-4 py-2">{{ $leave->reason->reason }}</td>
                <td class="px-4 py-2">
                    <span class="@if($leave->status == 'approved') text-green-600 
                                  @elseif($leave->status == 'pending') text-yellow-600 
                                  @else text-red-600 @endif font-semibold">
                        {{ ucfirst($leave->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">Aucun congé trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>



@endsection



