@extends('layout.app')

@section('title', 'Freelancer Projects')

@section('header', 'Freelancer Projects')

@section('content')
    @if(session('success'))
        <x-toast></x-toast>
    @endif
    <div class="bg-base-200 shadow rounded-lg" x-data="{ showModal: false, projectId: null, projectPrice: null, projectName: null, freelancerName: null }" x-cloak>
        <div class="flex justify-between items-center p-6 border-b border-base-300">
            <h2 class="text-xl font-semibold text-base-content">Freelancer Projects List</h2>
            @if(Auth::user()->can('create freelancer_projects'))
                <a href="{{ route('freelancer-projects.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i> Add Project
                </a>
            @endif
        </div>

        <div class="p-6 border-b border-base-300">
            <form action="{{ route('freelancer-projects.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-base-content mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md" placeholder="Search projects...">
                </div>

                <div>
                    <label for="employee_id" class="block text-sm font-medium text-base-content mb-1">Freelancer</label>
                    <select name="employee_id" id="employee_id" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md">
                        <option value="">All Freelancers</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->user->first_name . ' ' . $employee->user->first_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="price_min" class="block text-sm font-medium text-base-content mb-1">Min Price</label>
                    <input type="number" name="price_min" id="price_min" value="{{ request('price_min') }}" min="0" step="0.01" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md" placeholder="Min price">
                </div>

                <div>
                    <label for="price_max" class="block text-sm font-medium text-base-content mb-1">Max Price</label>
                    <input type="number" name="price_max" id="price_max" value="{{ request('price_max') }}" min="0" step="0.01" class="bg-base-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-base-300 rounded-md" placeholder="Max price">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 button-white">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                    <a href="{{ route('freelancer-projects.index') }}" class="flex items-center ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300  button-white">
                        <i class="fas fa-times mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-base-300">
                <thead class="bg-base-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Project Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Freelancer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Created At</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-base-content uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-base-content uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-base-200 divide-y divide-base-300">
                    @forelse($projects as $project)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-base-content">{{ $project->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($project->employee->profile_picture)
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/'.$project->employee->profile_picture) }}" alt="">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-base-content">
                                            {{ $project->employee->user->first_name .' '.$project->employee->user->last_name }}
                                        </div>
                                        <div class="text-sm text-base-content">
                                            {{ $project->employee->cin }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-base-content">{{ number_format($project->price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-base-content">{{ $project->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-bade-content">{{ $project->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-4 py-2 rounded-full text-white text-sm {{ $project->status?'bg-green-600':'bg-gray-500' }}">
                                    {{ ucfirst($project->status?'done':'working on') }}
                                </span>
                            </td>
                            <td class=" px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if(Auth::user()->can('edit freelancer_projects'))
                                    @if(!$project->status)
                                        <button type="button" @click="showModal = true; projectId = {{ $project->id }}; projectPrice = '{{ number_format($project->price, 2) }}'; freelancerName = '{{$project->employee->user->first_name . ' ' . $project->employee->user->last_name}}'; projectName='{{$project->name}}'" class="text-green-600 font-medium mr-2 aspect-square">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('freelancer-projects.edit', $project) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if(Auth::user()->can('delete freelancer_projects'))
                                    <form action="{{ route('freelancer-projects.destroy', $project) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this project?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                No freelancer projects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-base-300">
            {{ $projects->withQueryString()->links('vendor.pagination.tailwind') }}
        </div>

        <!-- Alpine.js Modal -->
        <!-- Overlay -->
        <div x-show="showModal" style='display:none' class="fixed  inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-base-200 rounded-lg shadow-lg max-w-md w-full p-6" @click.away="showModal = false">
                <h3 class="text-lg font-semibold mb-4">Confirm Payment</h3>
                <form method="POST" :action="`/freelancer-projects/${projectId}/done`">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-base-content">Project Name</label>
                        <input type="text" x-model="projectName" class="mt-1 block w-full border rounded-md p-2 bg-base-100" readonly />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-base-content">Freelancer Name</label>
                        <input type="text" x-model="freelancerName" class="mt-1 block w-full border rounded-md p-2 bg-base-100" readonly />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-base-content">Price</label>
                        <input type="text" x-model="projectPrice" class="mt-1 block w-full border rounded-md p-2 bg-base-100" readonly />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-base-content">Payment Type</label>
                        <select name="payment_type_id" class="mt-1 block w-full bg-base-100 border border-base-300 rounded-md p-2" required>
                            @foreach($paymentTypes as $type)
                                <option value="{{ $type->id }}" class='bg-base-100'>{{ $type->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="showModal = false" class="mr-3 px-4 py-2 bg-gray-300 text-black rounded button-white">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 focus:outline focus:outline-2 focus:outline-offset-2 rounded">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
