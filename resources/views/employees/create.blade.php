@extends('layout.app')

@section('title', 'Create Employee')

@section('header', 'Create Employee')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-base-200  border-base-300 shadow rounded-lg">
        <div class="p-6 border-b border-base-300">
            <h2 class="text-xl font-semibold text-base-content">Create New Employee</h2>
        </div>

        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{freelancer : '{{ old('is_freelancer','employee') }}'}">
                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-base-content mb-4">Basic Information</h3>
                </div>

                <div>
                    <label for="first_name" class="block text-sm font-medium text-base-content mb-1">First Name</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('first_name') border-red-500 @enderror" >
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-base-content mb-1">Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('last_name') border-red-500 @enderror" >
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-base-content mb-1">Email</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('email') border-red-500 @enderror" >
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-base-content mb-1">Password</label>
                    <input type="text" name="password" id="password" value="{{ old('password') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('password') border-red-500 @enderror" >
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-base-content mb-1">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('address') border-red-500 @enderror">
                    @error('address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="personal_num" class="block text-sm font-medium text-base-content mb-1">Personal Number</label>
                    <input type="text" name="personal_num" id="personal_num" value="{{ old('personal_num') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('personal_num') border-red-500 @enderror">
                    @error('personal_num')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="profile_picture" class="block text-sm font-medium text-base-content mb-1">Profile Picture <span class="text-gray-500 text-xs">(1080x1080px)</span></label>
                    <input type="file" name="profile_picture" id="profile_picture" class="file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('profile_picture') border-red-500 @enderror">
                    @error('profile_picture')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cin" class="block text-sm font-medium text-base-content mb-1">CIN</label>
                    <input type="text" name="cin" id="cin" value="{{ old('cin') }}" class=" bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('cin') border-red-500 @enderror" >
                    @error('cin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cin_attachment" class="block text-sm font-medium text-base-content mb-1">CIN Attachment</label>
                    <input type="file" name="cin_attachment" id="cin_attachment" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('cin_attachment') border-red-500  @enderror">
                    @error('cin_attachment')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-3">
                    <label for="department_id" class="block text-sm font-medium  text-base-content mb-1">Department</label>
                    <span>Search Department:</span> <input type="text" id="search_field" oninput="searching(event)" class="bg-base-100 shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-base-300 rounded-md">

                    <div class="overflow-y-auto grid md:grid-cols-3 gap-4 p-2 border border-base-300 rounded max-h-40 mt-2 @error('department_ids') border-red-500  @enderror">
                        @forelse($departments as $dep)
                            <label for="dep{{ $dep->id }}" class="deps border border-base-300 flex justify-center bg-base-100 rounded items-center py-4 ">
                                <div class="w-full px-6 flex gap-2 items-center">
                                    <input type="checkbox" name="department_ids[]" value="{{ $dep->id }}" id="dep{{ $dep->id }}" class="rounded bg-base-200">
                                    <label>{{ $dep->name }}</label>
                                </div>
                            </label>
                        @empty
                        @endforelse
                    </div>
                    @error('department_ids')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-3">
                    <h3 class="text-lg font-medium text-base-content mb-4">Additional Information</h3>
                </div>

                <span>
                    <input type='radio' @click="freelancer='employee'" value="employee" name="is_freelancer" @if(old('is_freelancer'))@if(old('is_freelancer') == 'employee') checked @endif @else checked   @endif > Employee
                </span>
                <span>
                    <input type='radio' @click="freelancer='freelancer'" value="freelancer" name="is_freelancer" @if(old('is_freelancer'))@if(old('is_freelancer') == 'freelancer') checked @endif @endif > FreeLancer
                </span>
                <span>
                    <input type='radio' @click="freelancer='trainee'" value="trainee" name="is_freelancer" @if(old('is_freelancer'))@if(old('is_freelancer') == 'trainee') checked @endif @endif > Trainee
                </span>

                <div x-show="freelancer==='freelancer'"  class="col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{salary:{{ old('is_project')?'false':'true' }}}">
                    <div>
                        <label for="ice" class="block text-sm font-medium text-base-content mb-1">ICE</label>
                        <input type="text" name="ice" id="ice" value="{{ old('ice') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('ice') border-red-500 @enderror">
                        @error('ice')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="is_project" class="flex items-center text-sm font-medium text-base-content mt-8 ">
                            <input @click="salary = !salary" type="checkbox" name="is_project" id="is_project" value="1" {{ old('is_project') ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-base-300 rounded bg-base-100 ">
                            <span class="ml-2">Is Project Based</span>
                        </label>
                        @error('is_project')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="salary">
                        <label for="salary_free" class="block text-sm font-medium text-base-content mb-1">Salary/Hour</label>
                        <input type="number" name="salary_free" id="salary_free" min="0" value="{{ old('salary_free') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('salary_free') border-red-500 @enderror">
                        @error('salary_free')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label for="eic" class="block text-sm font-medium text-base-content mb-1">Entrepreneur identification card</label>
                        <input type="file" name="eic" id="eic" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('eic') border-red-500  @enderror">
                        @error('eic')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div x-show="freelancer==='employee'" class="col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div>
                        <label for="type_id" class="block text-sm font-medium text-base-content mb-1">Type</label>
                        <select name="type_id" id="type_id" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('type_id') border-red-500 @enderror" >
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                @if($type->type === 'trainee' || $type->type === 'freelancer')
                                    @continue
                                @endif
                                    <option value="{{ $type->id }}" {{ old('type_id') == $type->type ? 'selected' : '' }}>
                                        {{ $type->type }}
                                    </option>
                            @endforeach
                        </select>
                        @error('type_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>



                    <div>
                        <label for="salary" class="block text-sm font-medium text-base-content mb-1">Salary</label>
                        <input type="number" name="salary" id="salary" min="0" value="{{ old('salary') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('salary') border-red-500 @enderror">
                        @error('salary')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="professional_email" class="block text-sm font-medium text-base-content mb-1">Professional Email</label>
                        <input type="email" name="professional_email" id="professional_email" value="{{ old('professional_email') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('professional_email') border-red-500 @enderror">
                        @error('professional_email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="professional_num" class="block text-sm font-medium text-base-content mb-1">Professional Number</label>
                        <input type="text" name="professional_num" id="professional_num" value="{{ old('professional_num') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('professional_num') border-red-500 @enderror">
                        @error('professional_num')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="pin" class="block text-sm font-medium text-base-content mb-1">PIN</label>
                        <input type="text" name="pin" id="pin" value="{{ old('pin') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('pin') border-red-500 @enderror">
                        @error('pin')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="puk" class="block text-sm font-medium text-base-content mb-1">PUK</label>
                        <input type="text" name="puk" id="puk" value="{{ old('puk') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('puk') border-red-500 @enderror">
                        @error('puk')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="operator_id" class="block text-sm font-medium text-base-content mb-1">Operator</label>
                        <select name="operator_id" id="operator_id" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('operator_id') border-red-500 @enderror">
                            <option value="">Select Operator</option>
                            @foreach($operators as $operator)
                                <option value="{{ $operator->id }}" {{ old('operator_id') == $operator->id ? 'selected' : '' }}>
                                    {{ $operator->operator }}
                                </option>
                            @endforeach
                        </select>
                        @error('operator_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cnss" class="block text-sm font-medium text-base-content mb-1">CNSS No.</label>
                        <input type="text" name="cnss" id="cnss" value="{{ old('cnss') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('cnss') border-red-500 @enderror">
                        @error('cnss')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="assurance" class="block text-sm font-medium text-base-content mb-1">Insurance Policy No.</label>
                        <input type="text" name="assurance" id="assurance" value="{{ old('assurance') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('assurance') border-red-500 @enderror">
                        @error('assurance')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="employment_contract" class="block text-sm font-medium text-base-content mb-1">Employment Contract</label>
                        <input type="file" name="employment_contract" id="employment_contract" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('employment_contract') border-red-500  @enderror">
                        @error('employment_contract')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="job_application" class="block text-sm font-medium text-base-content mb-1">Job Application</label>
                        <input type="file" name="job_application" id="job_application" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('job_application') border-red-500  @enderror">
                        @error('job_application')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="insurance" class="block text-sm font-medium text-base-content mb-1">Insurance</label>
                        <input type="file" name="insurance" id="insurance" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('insurance') border-red-500  @enderror">
                        @error('insurance')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="resume" class="block text-sm font-medium text-base-content mb-1">Resume</label>
                        <input type="file" name="resume" id="resume" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('resume') border-red-500  @enderror">
                        @error('resume')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cnss_certificate" class="block text-sm font-medium text-base-content mb-1">CNSS Certificate</label>
                        <input type="file" name="cnss_certificate" id="cnss_certificate" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('cnss_certificate') border-red-500  @enderror">
                        @error('cnss_certificate')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class='flex pt-6 items-center gap-2'>
                        <input type="checkbox" name="is_anapec" class="bg-base-100 rounded">ANAPEC
                    </div>
                </div>

                <div x-show="freelancer==='trainee'" class="col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{training_type:'{{ old('training_type') }}'}">
                    <div>
                        <label for="training_type" class="block text-sm font-medium text-base-content mb-1">Training Type</label>
                        <select x-model='training_type' name="training_type" id="training_type" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('training_type') border-red-500 @enderror" >
                            <option value="">Select Type</option>
                            <option value="observation">observation</option>
                            <option value="student">student</option>
                            <option value="PFE">PFE</option>
                            <option value="paid">paid</option>
                            <option value="work">work</option>
                        </select>
                        @error('training_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show='training_type === "student"'>
                        <label for="school" class="block text-sm font-medium text-base-content mb-1">School</label>
                        <input type="text" name="school" id="school" value="{{ old('school') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('school') border-red-500 @enderror">
                        @error('school')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="internship_agreement" class="block text-sm font-medium text-base-content mb-1">Internship Agreement</label>
                        <input type="file" name="internship_agreement" id="internship_agreement" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('internship_agreement') border-red-500  @enderror">
                        @error('internship_agreement')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="internship_application" class="block text-sm font-medium text-base-content mb-1">Internship Application</label>
                        <input type="file" name="internship_application" id="internship_application" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('internship_application') border-red-500  @enderror">
                        @error('internship_application')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="insurance_int" class="block text-sm font-medium text-base-content mb-1">Insurance</label>
                        <input type="file" name="insurance_int" id="insurance_int" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('insurance_int') border-red-500  @enderror">
                        @error('insurance_int')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="resume_int" class="block text-sm font-medium text-base-content mb-1">Resume</label>
                        <input type="file" name="resume_int" id="resume_int" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('resume_int') border-red-500  @enderror">
                        @error('resume_int')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="transcript" class="block text-sm font-medium text-base-content mb-1">Transcript</label>
                        <input type="file" name="transcript" id="transcript" class=" file-input shadow-sm focus:border-2 focus:ring-indigo-500 focus:outline-none h-[calc(0.25rem*9.5)] focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md @error('transcript') border-red-500  @enderror">
                        @error('transcript')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-4">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Employee
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function searching(e){
        const search = e.target.value.toLowerCase();
        const deps = document.querySelectorAll('.deps');

        deps.forEach(dep => {
            const text = dep.innerText.toLowerCase();
            console.log(text)
            if (text.includes(search)) {
                dep.style.display = 'block';
            } else {
                dep.style.display = 'none';
            }
        });
    };
</script>
@endpush

@endsection
