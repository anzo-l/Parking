<x-guest-layout>
    <div class="bg-white px-8 py-10 rounded-lg shadow-lg">
        <!-- Page Title -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Inscription</h1>
            <p class="text-gray-600">Créez votre compte</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nom')" class="text-gray-800 font-semibold" />
                <x-text-input id="name" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue" 
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-800 font-semibold" />
                <x-text-input id="email" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue" 
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-800 font-semibold" />
                <x-text-input id="password" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-gray-800 font-semibold" />
                <x-text-input id="password_confirmation" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-parking-primary-blue text-white font-bold py-2 px-4 rounded-full hover:opacity-90 transition">
                {{ __('VALIDER') }}
            </button>

            <!-- Link to Login -->
            <p class="text-center text-sm text-gray-600">
                Vous avez déjà un compte ? 
                <a href="{{ route('login') }}" class="text-parking-primary-blue font-bold hover:underline">
                    {{ __('Connexion') }}
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
