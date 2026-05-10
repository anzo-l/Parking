<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier l’historique d’attribution') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold mb-4">✏️ Modifier une attribution</h3>
                    <p class="mb-6 text-gray-600 dark:text-gray-400">
                        Ajustez l’utilisateur, la place ou les dates de l’attribution.
                    </p>

                    <form method="POST" action="{{ route('admin.historique.update', $record->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="utilisateur_id" :value="__('Utilisateur')" class="text-gray-800 font-semibold" />
                            <select id="utilisateur_id" name="utilisateur_id" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('utilisateur_id', $record->utilisateur_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('utilisateur_id')" class="mt-2 text-red-500" />
                        </div>

                        <div>
                            <x-input-label for="parking_space_id" :value="__('Place de parking')" class="text-gray-800 font-semibold" />
                            <select id="parking_space_id" name="parking_space_id" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue">
                                @foreach($places as $place)
                                    <option value="{{ $place->id }}" {{ old('parking_space_id', $record->parking_space_id) == $place->id ? 'selected' : '' }}>
                                        {{ $place->numero_place }} - {{ ucfirst($place->type_place) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('parking_space_id')" class="mt-2 text-red-500" />
                        </div>

                        <div>
                            <x-input-label for="date_debut" :value="__('Date d’attribution')" class="text-gray-800 font-semibold" />
                            <x-text-input id="date_debut" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue"
                                type="datetime-local" name="date_debut" value="{{ old('date_debut', $record->date_debut ? \Carbon\Carbon::parse($record->date_debut)->format('Y-m-d\TH:i') : '') }}" required />
                            <x-input-error :messages="$errors->get('date_debut')" class="mt-2 text-red-500" />
                        </div>

                        <div>
                            <x-input-label for="date_fin" :value="__('Date de fin')" class="text-gray-800 font-semibold" />
                            <x-text-input id="date_fin" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-parking-primary-blue"
                                type="datetime-local" name="date_fin" value="{{ old('date_fin', $record->date_fin ? \Carbon\Carbon::parse($record->date_fin)->format('Y-m-d\TH:i') : '') }}" />
                            <x-input-error :messages="$errors->get('date_fin')" class="mt-2 text-red-500" />
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <button type="submit" class="bg-parking-primary-blue text-white font-bold py-2 px-6 rounded-full hover:opacity-90 transition">
                                Enregistrer
                            </button>
                            <a href="{{ route('admin') }}" class="inline-flex items-center justify-center bg-gray-200 text-gray-800 py-2 px-6 rounded-full hover:bg-gray-300 transition">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
