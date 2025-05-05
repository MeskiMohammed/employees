@extends('layout.employee')

@section('title', 'Documents')

@section('header', 'My Documents')

@section('content')
@foreach($employee->typeEmployees as $typeEmployee)

<div class="bg-white rounded-lg shadow" x-data="{isOpen : false}" x-transition>
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-semibold text-gray-700">My Documents {{$typeEmployee->type->type}}</h2>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($typeEmployee->attachments as $place=>$attachment)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-yellow-100 rounded-md">
                            <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-900">{{$attachment->name}}</h3>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button @click="show = {{$place}} ; imageUrl='{{asset('storage/'.$attachment->attachment)}}'; id={{$attachment->id}}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        View Document
                    </button>
                </div>
            </div>
            @endforeach
        </div>
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

@endforeach


<div x-show='isOpen'>
    @foreach($typeEmployee->attachments as $place=>$attachment)
    <div class="mt-2 cursor-pointer flex justify-center bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
        <template x-if="show !== {{$place}}">
            <button @click="show = {{$place}} ; imageUrl='{{asset('storage/'.$attachment->attachment)}}'; id={{$attachment->id}}" class='w-full py-2 px-4 text-sm'>Show {{str_replace('_',' ',$attachment->name)}}</button>
        </template>
        <template x-if="show === {{$place}}">
            <button @click="show = null ; imageUrl=null" class='w-full py-2 px-4 text-sm'>Hide {{str_replace('_',' ',$attachment->name)}}</button>
        </template>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    // Document search functionality
    const searchInput = document.getElementById('document-search');
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const documentName = row.querySelector('td:first-child .text-gray-900').textContent.toLowerCase();
            const documentCategory = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            if (documentName.includes(searchTerm) || documentCategory.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Upload document modal
    const uploadBtn = document.getElementById('upload-document-btn');
    const uploadModal = document.getElementById('upload-document-modal');
    const cancelUploadBtn = document.getElementById('cancel-upload');

    uploadBtn.addEventListener('click', function() {
        uploadModal.classList.remove('hidden');
    });

    cancelUploadBtn.addEventListener('click', function() {
        uploadModal.classList.add('hidden');
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === uploadModal) {
            uploadModal.classList.add('hidden');
        }
    });

    // File upload preview
    const fileInput = document.getElementById('document-file');
    fileInput.addEventListener('change', function() {
        const fileName = this.files[0].name;
        const fileSize = (this.files[0].size / 1024).toFixed(2) + ' KB';

        const filePreview = document.createElement('div');
        filePreview.classList.add('mt-2', 'flex', 'items-center', 'p-2', 'bg-gray-50', 'rounded-md');
        filePreview.innerHTML = `
    <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    <div class="flex-1">
        <p class="text-sm font-medium text-gray-900">${fileName}</p>
        <p class="text-xs text-gray-500">${fileSize}</p>
    </div>
    <button type="button" class="text-gray-400 hover:text-gray-500" id="remove-file">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    `;

        const container = fileInput.closest('div').parentNode;

        // Remove existing preview if any
        const existingPreview = container.querySelector('.mt-2');
        if (existingPreview) {
            container.removeChild(existingPreview);
        }

        container.appendChild(filePreview);

        // Remove file functionality
        document.getElementById('remove-file').addEventListener('click', function() {
            fileInput.value = '';
            container.removeChild(filePreview);
        });
    });
</script>
@endsection