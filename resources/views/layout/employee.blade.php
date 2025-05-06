<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Employee Portal</title>

    <title>{{ \App\Models\Enterprise::first()->name ?? 'Enterprise' }}</title>
    <link rel="icon" href="{{asset('storage/' . \App\Models\Enterprise::first()->logo) }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://kit.fontawesome.com/7a09db649a.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <nav class="bg-white shadow-sm ">
            <div class="px-6">
                <div class="flex justify-between h-16">
                    <div class="flex items-center ">

                        <a class="flex items-center text-black pl-3" href="/" data-discover="true">
                            <img alt="logo-light" class="h-8 mr-2" src="{{asset('storage/' . \App\Models\Enterprise::first()->logo) }}" />
                            {{ \App\Models\Enterprise::first()->name ?? 'Enterprise' }}
                        </a>

                    </div>
                    @if (Auth::user()->hasRole('admin'))
                    <a href="{{ route('dashboard') }}" class="whitespace font-medium text-sm hover:text-black px-4 py-2 text-gray-700 rounded-md flex items-center "><i class="fa-solid fa-repeat mr-2"></i> Switch To AdminPanel</a>
                    @endif
                </div>
            </div>

        </nav>

        <div class="flex flex-1">


            <!-- Main content -->
            <div class="flex-1 overflow-auto">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                        <div class=" text-black pb-6 pt-4 relative">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                <div class="flex items-center">
                                    <div class="mr-6">
                                        @if($employee->profile_picture)
                                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="{{ $employee->first_name }} {{ $employee->last_name }}" class="h-36 w-36 rounded-md object-cover border-4 border-white rounded-3xl">
                                        @else
                                        <div class="h-36 w-36 rounded-md  flex items-center justify-center border-4 border-white">
                                            <span class="text-4xl font-bold text-black">{{ substr($employee->user->first_name, 0, 1) }}{{ substr($employee->user->last_name, 0, 1) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h1 class="text-3xl font-bold">{{ $employee->user->first_name }} {{ $employee->user->last_name }}</h1>
                                        <p class="">{{ $employee->typeEmployees->last()->type->type ?? 'No Position' }}</p>
                                    </div>

                                </div>



                                <div class="mt-6 border-b  flex justify-between">
                                    <nav class="-mb-px flex space-x-8">
                                        <a href="{{ route('employee.dashboard') }}" class="py-4 px-1 border-b-2  {{ request()->is('employee/dashboard') ? 'border-black' : 'border-transparent' }} font-medium text-sm text-black">Profile</a>
                                        @if ($employee->typeEmployees->last()->type->type == 'freelancer')
                                        <a href="{{ route('employee.projects') }}" class="py-4 px-1 border-b-2  {{ request()->is('employee/projects') ? 'border-black' : 'border-transparent' }} font-medium text-sm text-black">Projects</a>
                                        @endif
                                        <a href="{{ route('employee.leaves') }}" class="py-4 px-1 border-b-2  {{ request()->is('employee/leaves') ? 'border-black' : 'border-transparent' }} font-medium text-sm text-black">Leave Request</a>
                                        <a href="{{ route('employee.attachments') }}" class="py-4 px-1 border-b-2  {{ request()->is('employee/attachments') ? 'border-black' : 'border-transparent' }} font-medium text-sm text-black">Documents</a>
                                        <a href="{{ route('employee.payments') }}" class="py-4 px-1 border-b-2  {{ request()->is('employee/payments') ? 'border-black' : 'border-transparent' }} font-medium text-sm text-black">Payments</a>
                                    </nav>

                                    <form action='{{route('logout')}}' method='post'>
                                        @csrf
                                        <button class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm hover:text-black "><i class="fa-solid fa-right-from-bracket"></i> Log out </a>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');

        mobileMenuButton.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });

        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', function() {
            userMenu.classList.toggle('hidden');
        });

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 768 && !sidebar.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>

</html>