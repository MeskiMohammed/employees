<!DOCTYPE html>
<html lang="fr" data-theme='light'>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\Enterprise::first()->name ?? 'Enterprise' }}</title>
    <link rel="icon"
        href="{{\App\Models\Enterprise::first()->logo ? asset('storage/' . \App\Models\Enterprise::first()->logo) : asset('logo.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://kit.fontawesome.com/7a09db649a.js" crossorigin="anonymous"></script>
</head>

<body class=" min-h-screen bg-white flex items-center justify-center ">
    <div class="grid grid-cols-2 w-fullrounded-lg flex flex-col md:flex-row overflow-hidden justify-center items-center">

        <!-- Left: Image -->
        <div class="flex justify-center items-center bg-white">
            <img src="{{ asset('login-bg.png') }}" alt="" class="bg-white">
        </div>

        <!-- Right: Login Form -->
        <div class="flex justify-center items-center">
            <div class="w-96 p-10 rounded-xl">
                <div class='flex justify-center'><img
                    src="{{\App\Models\Enterprise::first()->logo ? asset('storage/' . \App\Models\Enterprise::first()->logo) : asset('logo.png') }}"
                        class='w-24'></div>
                <h1 class="text-2xl font-bold mb-6">Welcome</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for='email' class="block mb-1">Email</label>
                        <input type="email" name="email" id='email'
                            class="text-black w-full border rounded focus:border-primary-500 p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for='password' class="block mb-1">Password</label>
                        <input type="password" name="password" id='password'
                            class="text-black w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <label>remember me</label>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Login</button>
                </form>
            </div>
        </div>

    </div>

    <!-- Font Awesome (for icons) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>