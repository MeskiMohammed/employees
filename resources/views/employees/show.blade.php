@extends('layout.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Employee Details</h1>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        {{-- General Information --}}
        <h2 class="text-2xl font-semibold mb-4">General Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><strong>Full Name:</strong> {{ $employee->user->first_name }} {{ $employee->user->last_name }}</div>
            <div><strong>Email:</strong> {{ $employee->user->email }}</div>
            <div><strong>Personal Phone Number:</strong> {{ $employee->personal_num }}</div>
            <div><strong>Address:</strong> {{ $employee->address }}</div>
            <div><strong>CIN:</strong> {{ $employee->cin }}</div>
        </div>
    </div>

    {{-- Profile Picture and CIN Attachment --}}
    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <div class="flex-1">
            <h2 class="text-2xl font-semibold mb-4">Profile Picture</h2>
            <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture" class="rounded-lg w-64 h-64 object-cover">
        </div>

        <div class="flex-1">
            <h2 class="text-2xl font-semibold mb-4">CIN Attachment</h2>
            <img src="{{ asset('storage/' . $employee->cin_attachment) }}" alt="CIN Attachment" class="rounded-lg w-64 h-64 object-cover">
        </div>
    </div>

    {{-- Departments --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Departments</h2>
        <ul class="list-disc pl-5">
            @foreach ($employee->employeeDepartments as $department)
                <li>{{ $department->department->name }}</li>
            @endforeach
        </ul>
    </div>

    {{-- Type Specific Details --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-4">Type Specific Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Common to Freelancer, Trainee, Employee --}}
            <div><strong>Status:</strong> {{ ucfirst($employee->typeEmployees->last()->type->type) }}</div>

            @if ($employee->typeEmployees->last()->type->type === 'freelancer')
                <div><strong>ICE:</strong> {{ $employee->ice }}</div>
                @if ($employee->is_project)
                    <div><strong>Works by project:</strong> Yes</div>
                @else
                    <div><strong>Salary:</strong> {{ number_format($employee->salary, 2) }} DH</div>
                @endif

            @elseif ($employee->typeEmployees->last()->type->type === 'employee')
                <div><strong>Employee Code:</strong> {{ $employee->employee_code }}</div>
                <div><strong>Salary:</strong> {{ number_format($employee->salary, 2) }} DH</div>
                <div><strong>Professional Phone Number:</strong> {{ $employee->professional_num }}</div>
                <div><strong>Professional Email:</strong> {{ $employee->professional_email }}</div>
                <div><strong>SIM PIN:</strong> {{ $employee->pin }}</div>
                <div><strong>SIM PUK:</strong> {{ $employee->puk }}</div>
                <div><strong>Mobile Operator:</strong> {{ $employee->operator->name }}</div>
                <div><strong>CNSS:</strong> {{ $employee->cnss }}</div>
                <div><strong>Insurance:</strong> {{ $employee->assurance }}</div>

            @elseif ($employee->typeEmployees->last()->type->type === 'trainee')
                <div><strong>Trainee:</strong> No specific information.</div>
            @endif
        </div>
    </div>
</div>
@endsection

