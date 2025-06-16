@extends('layout.app')

@section('content')
    @if(session('success'))
        <x-toast></x-toast>
    @endif
    <div class="container mx-auto p-6"
        x-data="{ show: null, imageUrl:null, imageCIN:null, id:null, baseUrl:'{{route('attachments.download', ':id')}}'}">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-base-content">Employee Details</h1>
            <a href="{{ route('employees.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to Employees Page
            </a>
        </div>

        {{-- General Information --}}
        <div class="p-6 rounded-lg shadow-md border border-base-300 bg-base-200">
            <div class="flex justify-between border-b border-base-300 pb-1 mb-6">
                <h2 class="text-2xl font-semibold text-base-content ">
                    General Information
                    <span class="p-2 rounded text-center text-sm text-base-100 bg-base-content">
                        {{ ucfirst($employee->typeEmployees->last()->type->type) }}
                    </span>
                </h2>
                @if(Auth::user()->hasRole('super_admin'))
                    <form action='{{route('employees.toggleAdmin', $employee)}}' method='post' class="flex gap-4"
                        onsubmit="return confirm('Are you sure to give/remove admin to this user?')">
                        @csrf
                        @method('put')
                        @if(!in_array($employee->typeEmployees->last()->type->type,['trainee','freelancer']))
                            <a href="{{ route('badge', $employee) }}" target="_blank"
                                class='rounded px-4 py-2 bg-primary-500 text-black'>Badge</a>
                        @endif
                        @if($employee->typeEmployees->last()->type->type !== 'trainee')
                            <a href="{{ route('employees.payment', $employee) }}"
                                class='rounded px-4 py-2 bg-primary-500 text-black'>Payment History</a>
                        @endif
                        <button class='rounded px-4 py-2 bg-red-600 text-white'>
                            @if($employee->user->hasRole('admin'))
                                Remove Admin
                            @else
                                Add Admin
                            @endif
                        </button>
                    </form>
                @endif
            </div>

            <div class="flex flex-col xl:flex-row items-center justify-between  mb-6">
                {{-- Profile Picture and Status --}}
                <div class="flex flex-col md:flex-row gap-6 w-full">

                    <div class="flex flex-col items-center gap-2">
                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture" class="rounded-full w-40 h-40 object-cover border border-base-300 shadow-md">
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

                                <div for='cin'
                                    class="mt-2 cursor-pointer flex justify-center bg-primary-500 text-black rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    <template x-if="show !== 'cin'">
                                        <button
                                            @click="show = 'cin'; imageCIN = '{{ asset('storage/' . $employee->cin_attachment) }}'"
                                            id='cin' class='w-full py-2 px-4 text-sm'>Show CIN</button>
                                    </template>
                                    <template x-if="show === 'cin'">
                                        <button @click="show = null; imageCIN = null" id='cin'
                                            class='w-full py-2 px-4 text-sm'>Hide CIN</button>
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
                    <div class="flex-1 grid grid-cols-1">
                        @if ($employee->typeEmployees->last()->type->type === 'freelancer')
                            <div>
                                <strong>ICE:</strong>
                                <p>{{ $employee->ice }}</p>
                            </div>
                            <div>
                                <strong>Project Based:</strong>
                                <p>{{ $employee->is_project ? 'yes' : 'no' }}</p>
                            </div>
                            @if (!$employee->is_project)
                                <div>
                                    <strong>hourly salary:</strong>
                                    <p>{{ $employee->hourly_salary }} DH</p>
                                </div>
                            @endif
                        @elseif ($employee->typeEmployees->last()->type->type === 'trainee')
                            <div>
                                <strong>training type:</strong>
                                <p>{{ ucfirst($employee->training_type) }}</p>
                            </div>
                            @if ($employee->training_type === 'student')
                                <div>
                                    <strong>school:</strong>
                                    <p>{{ $employee->school }}</p>
                                </div>
                            @endif
                        @else
                            <div class="w-full grid grid-cols-1 sm:grid-cols-2 text-base-content">
                                <div>
                                    <strong>employee code:</strong>
                                    <p>{{ $employee->employee_code }}</p>
                                </div>
                                <div>
                                    <strong>salary:</strong>
                                    <p>{{ $employee->salary }}</p>
                                </div>
                                <div class='col-span-2'>
                                    <strong>professional email:</strong>
                                    <p>{{ $employee->professional_email }}</p>
                                </div>
                                <div>
                                    <strong>professional number:</strong>
                                    <p>{{ $employee->professional_num}}</p>
                                </div>
                                <div>
                                    <strong>pin:</strong>
                                    <p>{{ $employee->pin }}</p>
                                </div>
                                <div>
                                    <strong>puk:</strong>
                                    <p>{{ $employee->puk }}</p>
                                </div>
                                <div>
                                    <strong>Operator:</strong>
                                    <p>{{ $employee->operator->operator }}</p>
                                </div>
                                <div>
                                    <strong>ANAPEC:</strong>
                                    <p>{{ $employee->is_anapec ? 'yes' : 'no' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>


            <h2 class="flex justify-between mb-6 border-b border-base-300 pb-2">
                <span class='text-2xl font-semibold'>Posts</span>
                @if(\App\Models\TypeEmployee::where('employee_id', $employee->id)->where('out_date', null)->count() === 0)
                    <a href='{{ route('employees.edit', $employee) }}'
                        class='rounded px-4 py-2 bg-primary-500 cursor-pointer hover:bg-primary-300 text-black'>Add New Post</a>
                @endif
            </h2>
            @foreach($employee->typeEmployees->sortByDesc('created_at') as $typeEmployee)
                <div x-data="{isOpen : false}" class="my-4">
                    <div class='flex gap-4'>
                        <button @click='isOpen=!isOpen'
                            class='flex flex-1 justify-between p-4 bg-base-300 border border-base-300 rounded @if($typeEmployee->out_date === null) bg-primary-500 text-black  @endif'>
                            <div class='flex flex-col items-start'>
                                <p class='font-semibold'>{{$typeEmployee->type->type}}</p>
                            </div>
                            <div class='flex items-center justify-center'>
                                <span>{{$typeEmployee->in_date->format('d/m/Y')}}</span>
                                <i class="fa-solid fa-arrow-right mx-2"></i>
                                <span>{{$typeEmployee->out_date ? $typeEmployee->out_date->format('d/m/Y') : 'now'}}</span>
                            </div>
                        </button>
                        @if($typeEmployee->out_date === null && Auth::user()->can('edit employees'))
                            <form action="{{ route('employees.end-post', $employee) }}" method="post"
                                class="h-18.5 w-[calc(0.25rem*15)]" onsubmit="return confirm('Are you sure to end this post?')">
                                @csrf
                                @method('put')
                                <button
                                    class='cursor-pointer flex justify-center items-center bg-red-300 border border-red-600 text-red-600 rounded w-full h-full '><i
                                        class='fas fa-x'></i></button>
                            </form>
                        @endif
                    </div>
                    <div x-show='isOpen'>
                        @forelse($typeEmployee->attachments as $place => $attachment)
                            <div
                                class="mt-2 cursor-pointer flex justify-center bg-primary-500 text-black rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                <template x-if="show !== {{$place}}">
                                    <button
                                        @click="show = {{$place}} ; imageUrl='{{asset('storage/' . $attachment->attachment)}}'; id={{$attachment->id}}"
                                        class='w-full py-2 px-4 text-sm'>Show {{str_replace('_', ' ', $attachment->name)}}</button>
                                </template>
                                <template x-if="show === {{$place}}">
                                    <button @click="show = null ; imageUrl=null" class='w-full py-2 px-4 text-sm'>Hide
                                        {{str_replace('_', ' ', $attachment->name)}}</button>
                                </template>
                            </div>
                        @empty
                            <div
                                class="mt-2 cursor-pointer flex justify-center text-center bg-base-300 text-white rounded  transition">
                                <p class='w-full py-2 px-4 text-base-content text-sm'>No attachments</p>
                        @endforelse
                        </div>
                    </div>
            @endforeach

                <h2 class="flex justify-between mb-6 border-b border-base-300 pb-2">
                    <span class='text-2xl font-semibold'>Documents</span>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @if ($employee->typeEmployees()->firstWhere('type_id',$trainee_type_id))
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-yellow-100 rounded-md">
                                        <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-base-content">attestation de stage</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('documents.attestation_stage', $employee) }}" target="_blank"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-black bg-primary-300 hover:bg-gray-50 ">
                                    View Document
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-yellow-100 rounded-md">
                                        <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-base-content">attestation de travail</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('documents.attestation_travail', $employee) }}" target="_blank"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-black bg-primary-300  hover:bg-gray-50 focus:outline-none ">
                                    View Document
                                </a>
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-yellow-100 rounded-md">
                                        <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-base-content">attestation de mission</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('documents.attestation_mission', $employee) }}" target="_blank"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-black bg-primary-300 hover:bg-gray-50 focus:outline-none ">
                                    View Document
                                </a>
                            </div>
                        </div>
                        @if ($employee->typeEmployees->last()->type->type !== 'freelancer')


                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-yellow-100 rounded-md">
                                            <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-base-content">attestation de salaire</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('documents.attestation_salaire', $employee) }}" target="_blank"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-black bg-primary-300 hover:bg-gray-50 focus:outline-none  ">
                                        View Document
                                    </a>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-yellow-100 rounded-md">
                                            <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-base-content">bulletin de paie</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('documents.bulletin_paie', $employee) }}" target="_blank"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-black bg-primary-300 hover:bg-gray-50 focus:outline-none  ">
                                        View Document
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>


                @if($employee->user->hasRole('admin') && Auth::user()->hasRole('super_admin'))
                    <h2 class="text-2xl mt-6 font-semibold mb-6 text-base-content border-b border-base-300 pb-2">Permissions
                    </h2>
                    <form action='{{route('employees.assignPermissions', $employee)}}' method='post'
                        class='grid grid-cols-5 justify-center gap-y-4'>
                        @csrf
                        @method('put')
                        <span></span>
                        <span>Read</span>
                        <span>Create</span>
                        <span>Update</span>
                        <span>Delete</span>
                        @foreach($modules as $module)
                            <span>{{ucfirst(str_replace('_', ' ', $module))}}</span>
                            @if ($module === 'employees')
                                <input type='checkbox' name='permissions[]' value="{{'view' . ' ' . strtolower($module)}}"
                                    {{in_array('view' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                                <input type='checkbox' name='permissions[]' value="{{'create' . ' ' . strtolower($module)}}"
                                    {{in_array('create' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                                <input type='checkbox' name='permissions[]' value="{{'edit' . ' ' . strtolower($module)}}"
                                    {{in_array('edit' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                                <span></span>
                            @elseif ($module === 'leaves')
                                <input type='checkbox' name='permissions[]' value="{{'view' . ' ' . strtolower($module)}}"
                                    {{in_array('view' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                                <span></span>
                                <input type='checkbox' name='permissions[]' value="{{'edit' . ' ' . strtolower($module)}}"
                                    {{in_array('edit' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                                <span></span>
                            @else
                                @foreach(['view', 'create', 'edit', 'delete'] as $action)
                                    <input type='checkbox' name='permissions[]' value="{{$action . ' ' . strtolower($module)}}"
                                        {{in_array($action . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                                @endforeach
                            @endif
                        @endforeach
                        <div class='col-span-5 flex justify-end'>
                            <button class='rounded bg-blue-600 hover:bg-blue-700 px-4 py-2 text-white'>Save</button>
                        </div>
                    </form>
                @endif
            </div>

            {{-- Overlay --}}
            <div x-show="imageUrl" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed top-0 left-0 w-screen h-screen bg-black bg-opacity-75 p-6 z-50" style="display: none;"> {{--
                Hidden by default --}}

                <div class="px-4 flex gap-6 items-center justify-end">
                    <a :href="baseUrl . replace(':id', id)">
                        <i class="fa-solid fa-download scale-150 text-white"></i>
                    </a>
                    <button @click="show = null; imageUrl = null" class="text-white">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class='w-full h-full flex justify-center items-center'>
                    <img :src="imageUrl" alt="Enlarged Image" class="max-w-full max-h-full object-contain">
                </div>
            </div>

            <div x-show="imageCIN"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed top-0 left-0 w-screen h-screen bg-black bg-opacity-75 p-6 z-50"
                style="display: none;">

                <div class="px-4 flex gap-6 items-center justify-end">
                    <a href={{ route('employees.cin',$employee) }}>
                        <i class="fa-solid fa-download scale-150 text-white"></i>
                    </a>
                    <button @click="show = null; imageCIN = null" class="text-white">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class='w-full h-full flex justify-center items-center'>
                    <img :src="imageCIN" alt="Enlarged Image" class="max-w-full max-h-full object-contain">
                </div>
            </div>

        </div>
    </div>
@endsection