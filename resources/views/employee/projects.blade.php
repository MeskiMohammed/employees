
@extends('layout.employee')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
    <h2 class="text-lg font-semibold text-gray-700">Freelancer Projects</h2>
    </div>
    <form method="GET" action="{{ route('employee.projects') }}">
    <div class="p-6">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                
                {{-- Year Filter --}}
                <div class="relative">
                    <select name="year" id="year-filter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="">All Years</option>
                        @for ($y = now()->year; $y >= 2022; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Month Filter --}}
                <div class="relative">
                    <select name="month" id="month-filter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="">All Months</option>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Submit Button --}}
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>

           
</form>

                <a href="{{ route('employee.projects') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            </div>
            </div>
        </div>
<div class="container mx-auto p-4">

        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                 @foreach ($projects as $project)
                        

                 <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                        {{ $project->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        {{ $project->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap ">
                            <span class="px-4 py-2 rounded-full text-white text-sm {{ $project->status?'bg-green-600':'bg-gray-500' }}">
                                {{ ucfirst($project->status?'done':'working on') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        {{ $project->price }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap ">
                        {{ $project->created_at->format('Y-m-d') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
@endsection 
 