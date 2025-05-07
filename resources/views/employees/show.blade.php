@extends('layout.app')

@section('content')
@if(session('success'))
        <x-toast></x-toast>
    @endif
<div class="container mx-auto p-6" x-data="{ show: null, imageUrl:null, id:null, baseUrl:'{{route('attachments.download',':id')}}'}">
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
                    {{ ucfirst( $employee->typeEmployees->last()->type->type ) }}
                </span>
            </h2>
            @if(Auth::user()->hasRole('super_admin'))
            <form action='{{route('employees.toggleAdmin',$employee)}}' method='post' class="flex gap-4" onsubmit="return confirm('Are you sure to give/remove admin to this user?')">
                @csrf
                @method('put')
                <a href="{{ route('employees.payment',$employee) }}" class='rounded px-4 py-2 bg-blue-600 text-white'>Payment History</a>
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
                <div class="flex-1 grid grid-cols-1">
                    @if ($employee->typeEmployees->last()->type->type === 'freelancer')
                    <div>
                        <strong>ICE:</strong>
                        <p>{{ $employee->ice }}</p>
                    </div>
                    <div>
                        <strong>Project Based:</strong>
                        <p>{{ $employee->is_project?'yes':'no' }}</p>
                    </div>
                    @if (!$employee->is_project)
                    <div>
                        <strong>hourly salary:</strong>
                        <p>{{ $employee->salary }} DH</p>
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
                        <div>
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
                    </div>
                    @endif
                </div>
            </div>
        </div>


        <h2 class="flex justify-between mb-6 border-b border-base-300 pb-2">
            <span class='text-2xl font-semibold'>Posts</span>
            @if(\App\Models\TypeEmployee::where('employee_id',$employee->id)->where('out_date',null)->count() === 0 )
            <a href='{{ route('employees.edit',$employee) }}' class='rounded px-4 py-2 bg-blue-600 cursor-pointer hover:bg-blue-700 text-white'>Add New Post</a>
            @endif
        </h2>
        @foreach($employee->typeEmployees->sortByDesc('created_at') as $typeEmployee)
        <div x-data="{isOpen : false}" class="my-4">
            <div class='flex gap-4'>
                <button @click='isOpen=!isOpen' class='flex flex-1 justify-between p-4 bg-base-300 border border-base-300 rounded @if($typeEmployee->out_date === null) bg-green-400 text-black border-green-600 @endif'>
                    <div class='flex flex-col items-start'>
                        <p class='font-semibold'>{{$typeEmployee->type->type}}</p>
                    </div>
                    <div class='flex items-center justify-center'>
                        <span>{{$typeEmployee->in_date}}</span>
                        <i class="fa-solid fa-arrow-right mx-2"></i>
                        <span>{{$typeEmployee->out_date ?? 'now'}}</span>
                    </div>
                </button>
                @if($typeEmployee->out_date === null && Auth::user()->can('edit employees'))
                <form action="{{ route('employees.end-post',$employee) }}" method="post" class="h-18.5 w-[calc(0.25rem*15)]" onsubmit="return confirm('Are you sure to end this post?')">
                    @csrf
                    @method('put')
                    <button class='cursor-pointer flex justify-center items-center bg-red-300 border border-red-600 text-red-600 rounded w-full h-full '><i class='fas fa-x'></i></button>
                </form>
                @endif
            </div>
            <div x-show='isOpen'>
                @forelse($typeEmployee->attachments as $place=>$attachment)
                <div class="mt-2 cursor-pointer flex justify-center bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <template x-if="show !== {{$place}}">
                        <button @click="show = {{$place}} ; imageUrl='{{asset('storage/'.$attachment->attachment)}}'; id={{$attachment->id}}" class='w-full py-2 px-4 text-sm'>Show {{str_replace('_',' ',$attachment->name)}}</button>
                    </template>
                    <template x-if="show === {{$place}}">
                        <button @click="show = null ; imageUrl=null" class='w-full py-2 px-4 text-sm'>Hide {{str_replace('_',' ',$attachment->name)}}</button>
                    </template>
                </div>
                @empty
                <div class="mt-2 cursor-pointer flex justify-center text-center bg-base-300 text-white rounded  transition">
                    <p class='w-full py-2 px-4 text-base-content text-sm'>No attachments</p>
                    @endforelse
                </div>
            </div>
            @endforeach

            @if($employee->user->hasRole('admin')&& Auth::user()->hasRole('super_admin'))
            <h2 class="text-2xl mt-6 font-semibold mb-6 text-base-content border-b border-base-300 pb-2">Permissions</h2>
            <form action='{{route('employees.assignPermissions',$employee)}}' method='post' class='grid grid-cols-5 justify-center gap-y-4'>
                @csrf
                @method('put')
                <span></span>
                <span>Read</span>
                <span>Create</span>
                <span>Update</span>
                <span>Delete</span>
                @foreach($modules as $module)
                <span>{{ucfirst(str_replace('_',' ',$module))}}</span>
                @if ($module === 'employees')
                <input type='checkbox' name='permissions[]' value="{{'view' . ' ' . strtolower($module)}}" {{in_array('view' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                <input type='checkbox' name='permissions[]' value="{{'create' . ' ' . strtolower($module)}}" {{in_array('create' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                <input type='checkbox' name='permissions[]' value="{{'edit' . ' ' . strtolower($module)}}" {{in_array('edit' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                <span></span>
                @elseif ($module === 'leaves')
                <input type='checkbox' name='permissions[]' value="{{'view' . ' ' . strtolower($module)}}" {{in_array('view' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                <span></span>
                <input type='checkbox' name='permissions[]' value="{{'edit' . ' ' . strtolower($module)}}" {{in_array('edit' . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
                <span></span>
                @else
                @foreach(['view','create','edit','delete'] as $action)
                <input type='checkbox' name='permissions[]' value="{{$action . ' ' . strtolower($module)}}" {{in_array($action . ' ' . strtolower($module), $employee->user->getPermissionNames()->toArray()) ? 'checked' : ''}}>
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
        <div x-show="imageUrl"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-0 left-0 w-screen h-screen bg-black bg-opacity-75 p-6 z-50"
            style="display: none;"> {{-- Hidden by default --}}

            <div class="px-4 flex gap-6 items-center justify-end">
                <a :href="baseUrl.replace(':id',id)">
                    <i class="fa-solid fa-download scale-150 text-white"></i>
                </a>
                <button @click="show = null; imageUrl = null" class="text-white">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class='w-full h-full flex justify-center items-center'>
                <img :src="imageUrl" alt="Enlarged Image" class="max-w-full max-h-full object-contain">
            </div>
        </div>
    </div>
</div>
@endsection