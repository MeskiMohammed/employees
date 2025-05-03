@extends('layout.app')

@section('content')
    <div class="container mx-auto p-6" x-data="{ show: null, imageUrl:null }">
        <h1 class="text-3xl font-bold mb-6">Employee Details</h1>

        {{-- General Information --}}
        <div class="p-6 rounded-lg shadow-md border border-base-300 bg-base-200" >
            <h2 class="text-2xl font-semibold mb-6 text-base-content border-b border-base-300 pb-2">General Information <span class="p-2 rounded text-center text-sm text-base-100 bg-base-content"> {{ ucfirst($employee->typeEmployees->last()->type->type) }}</span> </h2>



            <div class="flex flex-col xl:flex-row items-center justify-between  mb-6">
                {{-- Profile Picture and Status --}}
                <div class="flex flex-col md:flex-row items-center gap-6">

                    <div class="flex flex-col items-center gap-2">
                        <img @click="imageUrl='{{asset('storage/'.$employee->profile_picture)}}'" src="{{ asset('storage/' . $employee->profile_picture) }}"
                        alt="Profile Picture"
                        class="rounded-full w-40 h-40 object-cover border border-base-300 cursor-pointer shadow-md">
                    </div>

                    {{-- Profile Info Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-base-content">
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
                            <div class='flex items-center gap-2'>
                                <p>{{ $employee->cin }}</p>

                                <div for='cin' class="mt-2 cursor-pointer flex justify-center bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    <template x-if="show !== 'cin'">
                                        <button @click="show = 'cin'; imageUrl = '{{ asset('storage/' . $employee->cin_attachment) }}'" id='cin' class='w-full py-2 px-4 text-sm'>Show CIN</button>
                                    </template>
                                    <template x-if="show === 'cin'">
                                        <button @click="show = null; imageUrl = null" id='cin' class='w-full py-2 px-4 text-sm'>Hide CIN</button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div>
                            <strong>Departments:</strong>
                            <ul class="list-disc pl-4">
                                @foreach ($employee->employeeDepartments as $department)
                                    <li>{{ $department->department->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">

                </div>
            </div>


            <h2 class="text-2xl font-semibold mb-6 text-base-content border-b border-base-300 pb-2">Posts</h2>
            @foreach($employee->typeEmployees as $typeEmployee)
                <div x-data="{isOpen : false}" x-transition>
                    <button @click='isOpen=!isOpen' class='flex justify-between w-full p-4 bg-base-100 border border-base-300 rounded @if($typeEmployee->out_date === null) bg-green-400 text-black border-green-600 @endif'>
                        <div class='flex flex-col items-start'>
                            <p class='font-semibold'>{{$typeEmployee->type->type}}</p>
                            <p class='text-xs'>{{$typeEmployee->description}}</p>
                        </div>
                        <div class='flex items-center justify-center'>
                            {{$typeEmployee->in_date}}
                            <i class="fa-solid fa-arrow-right mx-2"></i>
                            {{$typeEmployee->out_date ?? 'now'}}
                        </div>
                    </button>
                    <div x-show='isOpen'>
                        @foreach($typeEmployee->attachments as $place=>$attachment)
                            <div class="mt-2 cursor-pointer flex justify-center bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                <template x-if="show !== {{$place}}">
                                    <button @click="show = {{$place}} ; imageUrl='{{asset('storage/'.$attachment->attachment)}}'" class='w-full py-2 px-4 text-sm'>Show {{str_replace('_',' ',$attachment->name)}}</button>
                                </template>
                                <template x-if="show === {{$place}}">
                                    <button @click="show = null ; imageUrl=null" class='w-full py-2 px-4 text-sm'>Hide {{str_replace('_',' ',$attachment->name)}}</button>
                                </template>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            @if($employee->user->hasRole('admin'))
                <h2 class="text-2xl font-semibold mb-6 text-base-content border-b border-base-300 pb-2">Permissions</h2>

            @endif
        </div>

        {{-- Overlay --}}
        <div x-show="imageUrl"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-0 left-0 w-screen h-screen bg-black bg-opacity-75 p-6 z-50"
            style="display: none;">  {{-- Hidden by default --}}

            <div class="px-4 flex items-center justify-end">
                <button @click="show = null; imageUrl = null" class="text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class='w-full h-full flex justify-center items-center'>
                <img :src="imageUrl" alt="Enlarged Image" class="max-w-full max-h-full object-contain">
            </div>
        </div>
    </div>
@endsection
