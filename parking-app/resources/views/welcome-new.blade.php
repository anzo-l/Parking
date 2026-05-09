<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Parking M2L') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen flex flex-col">
            <!-- Header with Logo and Navigation -->
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
            <main class="flex-1 w-full py-12 px-6">
                <div class="max-w-4xl mx-auto text-center">
                    <!-- Title Section -->
                    <div class="mb-12">
                        <p class="text-gray-600 text-lg mb-2">Bienvenue</p>
                        <h1 class="text-5xl font-bold text-gray-900">PARKING M2L</h1>
                    </div>

                    <!-- Parking Lot Visualization -->
                    <div class="bg-parking-dark-gray p-8 rounded-lg inline-block">
                        <!-- Grid of Parking Spaces (2 rows, 5 columns) -->
                        <div class="grid grid-cols-5 gap-6">
                            <!-- Row 1 -->
                            <!-- Space 1 - Blue Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-blue-500 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-blue-600 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Space 2 - Yellow Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-yellow-400 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-yellow-500 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Space 3 - Pink Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-pink-500 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-pink-600 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Space 4 - Cyan Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-cyan-400 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-cyan-500 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Space 5 - Purple Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-purple-500 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-purple-600 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <!-- Space 6 - Gray Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-gray-400 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-gray-500 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Space 7 - Red Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-red-500 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-red-600 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Space 8 - Green Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-green-500 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-green-600 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Space 9 - Magenta Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-fuchsia-500 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-fuchsia-600 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Space 10 - Orange Car -->
                            <div class="relative w-20 h-24 border-2 border-dashed border-white flex items-center justify-center">
                                <div class="w-16 h-14 bg-orange-400 rounded relative shadow-lg">
                                    <div class="absolute top-2 left-2 right-2 h-3 bg-orange-500 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons for Not Authenticated Users -->
                    @if (!Auth::check())
                        <div class="mt-12 flex gap-6 justify-center">
                            <a href="{{ route('login') }}" class="px-8 py-3 bg-gray-300 text-gray-800 rounded-full font-bold hover:bg-gray-400 transition">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="px-8 py-3 bg-gray-300 text-gray-800 rounded-full font-bold hover:bg-gray-400 transition">
                                Inscription
                            </a>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </body>
</html>
