<x-guest-layout>
    <div class="bg-white px-8 py-10 rounded-lg shadow-lg">
        <!-- Page Title -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Connexion</h1>
            <p class="text-gray-600">Connectez-vous à votre compte</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-800 font-semibold" />
                <x-text-input id="email" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue" 
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-800 font-semibold" />
                <x-text-input id="password" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300" name="remember">
                <label for="remember_me" class="ms-2 text-sm text-gray-600">
                    {{ __('Se souvenir de moi') }}
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-parking-primary-blue text-white font-bold py-2 px-4 rounded-full hover:opacity-90 transition">
                {{ __('VALIDER') }}
            </button>

            <!-- Links -->
            <div class="flex flex-col gap-4 text-center text-sm">
                @if (Route::has('password.request'))
                    <a class="text-parking-primary-blue hover:underline" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié?') }}
                    </a>
                @endif
                
                <p class="text-gray-600">
                    Pas de compte ? 
                    <a href="{{ route('register') }}" class="text-parking-primary-blue font-bold hover:underline">
                        S'inscrire
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
