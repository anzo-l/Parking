<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen flex flex-col">
            <!-- Header with Navigation -->
            <header class="bg-parking-header-gray px-6 py-4 border-b-4 border-parking-primary-blue">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    <!-- Logo -->
                    <a href="{{ route('welcome') }}" class="flex items-center">
                        <div class="w-12 h-12 bg-parking-primary-blue rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">P</span>
                        </div>
                    </a>

                    <!-- Navigation Links -->
                    <nav class="flex items-center gap-8">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-800 font-bold hover:underline">Accueil</a>
                            <a href="{{ route('dashboard') }}" class="text-gray-800 font-bold hover:underline">Réservation</a>
                            @if(auth()->user()?->is_admin)
                                <a href="{{ route('admin') }}" class="text-parking-primary-blue font-bold hover:underline">Administration</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-800 font-bold hover:underline">Déconnecté</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-800 font-bold hover:underline">Connexion</a>
                            <a href="{{ route('register') }}" class="text-gray-800 font-bold hover:underline">Inscription</a>
                        @endauth
                    </nav>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 w-full">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
