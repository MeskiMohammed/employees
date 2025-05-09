<!DOCTYPE html>
<html lang="fr" data-theme='dark'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
</head>
<body class="bg-base-300 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-5xl bg-white shadow-lg rounded-lg flex flex-col md:flex-row overflow-hidden">

        <!-- Left: Image -->
        <div class="md:w-1/2 w-full flex items-center justify-center p-10" style="background-image: url({{ asset('login-bg.jpeg') }})">
            <!--<div class="text-white text-center">
                <h2 class="text-2xl font-bold mb-4">Gestion Simplifiée</h2>
                <p class="mb-4">With eTwin technology</p>
                <div class="flex justify-center space-x-4">
                    <i class="fab fa-facebook text-xl"></i>
                    <i class="fab fa-whatsapp text-xl"></i>
                    <i class="fab fa-instagram text-xl"></i>
                </div>
            </div>-->
        </div>

        <!-- Right: Login Form -->
        <div class="md:w-1/2 w-full p-10 bg-black border-l border-white">
            <div class='flex justify-center'><img src='{{asset('logo.jpeg')}}' class='w-24'></div>
            <h1 class="text-2xl font-bold mb-6">Welcome</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for='email' class="block mb-1">Email</label>
                    <input type="email" name="email" id='email' class="text-black w-full border rounded focus:border-primary-500 p-2" required>
                </div>
                <div class="mb-4">
                    <label for='password' class="block mb-1">Password</label>
                    <input type="password" name="password" id='password' class="text-black w-full border rounded p-2" required>
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <label>remember me</label>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Login</button>
            </form>
        </div>
    </div>

    <!-- Font Awesome (for icons) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
