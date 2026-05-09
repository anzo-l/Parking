<x-guest-layout>
    <div class="bg-white px-8 py-10 rounded-lg shadow-lg">
        <!-- Page Title -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mot de passe oublié</h1>
            <p class="text-gray-600">Réinitialisez votre mot de passe</p>
        </div>

        <div class="mb-6 text-sm text-gray-600">
            {{ __('Vous avez oublié votre mot de passe ? Aucun problème. Entrez simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe qui vous permettra de choisir un nouveau mot de passe.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-800 font-semibold" />
                <x-text-input id="email" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue" 
                    type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-parking-primary-blue text-white font-bold py-2 px-4 rounded-full hover:opacity-90 transition">
                {{ __('Envoyer le lien') }}
            </button>

            <!-- Back to Login -->
            <p class="text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-parking-primary-blue font-bold hover:underline">
                    {{ __('Retour à la connexion') }}
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>
