<!DOCTYPE html>
<html lang="en">
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
            
                    
                    <div class="flex items-center">
                       
        </nav>
        
        <div class="flex flex-1">
          
            
            <!-- Main content -->
            <div class="flex-1 overflow-auto">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('header')</h1>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
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
