@extends('layout.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Employee Details</h1>

    {{-- General Information --}}
    <div class="p-6 rounded-lg shadow-md bg-white" x-data="{ showCin: false }">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-2">General Information <span class="p-2 rounded text-center text-sm text-base-100 bg-base-content"> {{ ucfirst($employee->typeEmployees->last()->type->type) }}</span> </h2>



        <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
            {{-- Profile Picture and Status --}}
            <div class="flex flex-col items-center gap-2">
                <img src="{{ asset('storage/' . $employee->profile_picture) }}"
                    alt="Profile Picture"
                    class="rounded-full w-40 h-40 object-cover border border-gray-300 shadow-md">


            </div>

            {{-- Profile Info Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
                <div>
                    <strong>Full Name:</strong>
                    <p>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</p>
                </div>
                <div>
                    <strong>Email:</strong>
                    <p>{{ $employee->user->email }}</p>
                </div>
                <div>
                    <strong>Personal Phone Number:</strong>
                    <p>{{ $employee->personal_num }}</p>
                </div>
                <div>
                    <strong>Address:</strong>
                    <p>{{ $employee->address }}</p>
                </div>
                <div>
                    <strong>CIN:</strong>
                    <p>{{ $employee->cin }}</p>
                </div>
                <div>
                    <strong>Departments:</strong>
                    <ul class="list-disc pl-4">
                        @foreach ($employee->employeeDepartments as $department)
                        <li>{{ $department->department->name }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-span-2">
                    <button @click="showCin = !showCin"
                        class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        <template x-if="!showCin">
                            <span>Show CIN Attachment</span>
                        </template>
                        <template x-if="showCin">
                            <span>Hide CIN Attachment</span>
                        </template>
                    </button>
                </div>
            </div>
        </div>

        {{-- CIN Attachment Toggle --}}
        <div class="mt-6">
            <div x-show="showCin" x-transition class="flex justify-center">
                <img src="{{ asset('storage/' . $employee->cin_attachment) }}"
                    alt="CIN Attachment"
                    class="rounded-lg w-64 h-64 object-cover border border-gray-300 shadow">
            </div>
        </div>
    </div>










    @endsection