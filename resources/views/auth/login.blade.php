<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - FSJES Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f2f6fc] min-h-screen flex items-center justify-center">
    <div class="w-full max-w-5xl bg-white shadow-lg rounded-lg flex flex-col md:flex-row overflow-hidden">
        
        <!-- Left: Image -->
        <div class="md:w-1/2 w-full flex items-center justify-center p-10" style="background-image: '{{ asset('storage/login-bg.jpg') }}'">
            <div class="text-white text-center">
                <h2 class="text-2xl font-bold mb-4">Gestion Simplifiée</h2>
                <p class="mb-4">With eTwin technology</p>
                <div class="flex justify-center space-x-4">
                    <i class="fab fa-facebook text-xl"></i>
                    <i class="fab fa-whatsapp text-xl"></i>
                    <i class="fab fa-instagram text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Right: Login Form -->
        <div class="md:w-1/2 w-full p-10">
            <h1 class="text-2xl font-bold mb-6">Bienvenue</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Adresse e-mail</label>
                    <input type="email" name="email" class="w-full border rounded p-2" placeholder="vous@example.com" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Mot de passe</label>
                    <input type="password" name="password" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <label>Se souvenir de moi</label>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Se connecter</button>
            </form>
        </div>
    </div>

    <!-- Font Awesome (for icons) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
