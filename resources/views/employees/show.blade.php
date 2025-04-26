@extends('layout.app')

@section('title', 'Employee Details')

@section('header', 'Employee Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Employees
        </a>
        <div>
            <a href="{{ route('employees.edit', $employee) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this employee?')">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-24 w-24">
                    @if($employee->profile_picture)
                        <img class="h-24 w-24 rounded-full object-cover" src="{{ Storage::url($employee->profile_picture) }}" alt="{{ $employee->user->full_name ?? 'Employee' }}">
                    @else
                        <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                    @endif
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $employee->user->full_name ?? 'N/A' }}</h2>
                    <p class="text-sm text-gray-500">{{ $employee->employee_code }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $employee->status ? ($employee->status->status === 'active' ? 'green' : 'red') : 'gray' }}-100 text-{{ $employee->status ? ($employee->status->status === 'active' ? 'green' : 'red') : 'gray' }}-800">
                            {{ $employee->status->status ?? 'N/A' }}
                        </span>
                        <span class="ml-2 text-sm text-gray-500">{{ $employee->department->name ?? 'No Department' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">CIN</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->cin }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Department</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->department->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Operator</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->operator->operator ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $employee->status ? ($employee->status->status === 'active' ? 'green' : 'red') : 'gray' }}-100 text-{{ $employee->status ? ($employee->status->status === 'active' ? 'green' : 'red') : 'gray' }}-800">
                            {{ $employee->status->status ?? 'N/A' }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Professional Email</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->professional_email ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Professional Number</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->professional_num ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Personal Number</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->personal_num ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->adress ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Employment Details</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Salary</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->salary ? number_format($employee->salary, 2) : 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Project Based</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->is_project ? 'Yes' : 'No' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Hours</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->houres ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">PIN</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->pin ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">PUK</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->puk ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">ICE</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->ice ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">CNSS</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->cnss ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Assurance</p>
                        <p class="text-base font-medium text-gray-900">{{ $employee->assurance ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Related Information</h3>
                
                <div class="bg-gray-50 p-4 rounded-md">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('payments.index', ['employee_id' => $employee->id]) }}" class="bg-white p-4 rounded-md shadow hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-blue-100 text-blue-500">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Payments</p>
                                    <p class="text-sm text-gray-500">{{ $employee->payments->count() }} records</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('leaves.index', ['employee_id' => $employee->id]) }}" class="bg-white p-4 rounded-md shadow hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-green-100 text-green-500">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Leaves</p>
                                    <p class="text-sm text-gray-500">{{ $employee->leaves->count() }} records</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('evaluations.index', ['employee_id' => $employee->id]) }}" class="bg-white p-4 rounded-md shadow hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-yellow-100 text-yellow-500">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Evaluations</p>
                                    <p class="text-sm text-gray-500">{{ $employee->evaluations->count() }} records</p>
                                </div>
                            </div>
                        </a>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
