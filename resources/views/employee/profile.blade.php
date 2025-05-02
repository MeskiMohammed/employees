@extends('layout.employee')

@section('title', 'My Profile')

@section('header', 'My Profile')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class=" text-white p-6">
            <div class="flex flex-col md:flex-row md:items-center">
                <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                    @if($employee->profile_picture)
                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="{{ $employee->first_name }} {{ $employee->last_name }}" class="h-32 w-32 rounded-full object-cover border-4 border-white">
                    @else
                        <div class="h-32 w-32 rounded-full  flex items-center justify-center border-4 border-white">
                            <span class="text-4xl font-bold text-white">{{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold">{{ $employee->first_name }} {{ $employee->last_name }}</h1>
                    <p class="">{{ $employee->post->post ?? 'No Position' }}</p>
                    <p class=" mt-1">{{ $employee->department->name ?? 'No Department' }}</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('employee.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white  rounded-md  focus:outline-none focus:ring-2 focus:ring-offset-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit Profile
                        </a>
                        <a href="{{ route('employee.documents') }}" class="inline-flex items-center px-4 py-2 bg-white  rounded-md  focus:outline-none focus:ring-2 focus:ring-offset-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Documents
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h2>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">First Name</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->first_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Last Name</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->last_name }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email Address</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->email }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Personal Phone</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->personal_num ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Work Phone</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->professional_num ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Address</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->address ?? 'Not provided' }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->birth_date ? $employee->birth_date->format('M d, Y') : 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Gender</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->gender ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Employment Information</h2>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Employee ID</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Join Date</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Department</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->department->name ?? 'Not assigned' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Position</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $employee->post->post ?? 'Not assigned' }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Employment Type</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->is_freelancer ? 'Freelancer' : 'Full-Time Employee' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Work Email</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->professional_email ?? $employee->email }}</p>
                        </div>
                        
                        @if($employee->manager)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Manager</p>
                            <div class="mt-2 flex items-center">
                                @if($employee->manager->profile_picture)
                                    <img src="{{ asset('storage/' . $employee->manager->profile_picture) }}" alt="{{ $employee->manager->first_name }} {{ $employee->manager->last_name }}" class="h-8 w-8 rounded-full mr-2">
                                @else
                                    <div class="h-8 w-8 rounded-full  flex items-center justify-center mr-2">
                                        <span class="text-xs font-bold text-white">{{ substr($employee->manager->first_name, 0, 1) }}{{ substr($employee->manager->last_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <span class="text-sm text-gray-900">{{ $employee->manager->first_name }} {{ $employee->manager->last_name }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Skills & Qualifications</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    @if(count($employee->skills ?? []) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($employee->skills as $skill)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No skills added yet</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    @if($employee->emergency_contact_name)
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Name</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $employee->emergency_contact_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Relationship</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $employee->emergency_contact_relationship ?? 'Not specified' }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Phone</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $employee->emergency_contact_phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $employee->emergency_contact_email ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No emergency contact added yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
