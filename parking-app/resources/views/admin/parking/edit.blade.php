<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier la Place de Parking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('admin.parking.update', $place->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Numéro Place -->
                        <div class="mb-4">
                            <label for="numero_place" class="block mb-2 font-medium">Numéro de Place</label>
                            <input type="text" id="numero_place" name="numero_place" value="{{ old('numero_place', $place->numero_place) }}" 
                                class="w-full px-4 py-2 border rounded-lg @error('numero_place') border-red-500 @enderror" required>
                            @error('numero_place')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type Place -->
                        <div class="mb-4">
                            <label for="type_place" class="block mb-2 font-medium">Type de Place</label>
                            <select id="type_place" name="type_place" class="w-full px-4 py-2 border rounded-lg @error('type_place') border-red-500 @enderror" required>
                                <option value="normal" {{ old('type_place', $place->type_place) === 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="pmr" {{ old('type_place', $place->type_place) === 'pmr' ? 'selected' : '' }}>PMR (Handicapé)</option>
                                <option value="reserve" {{ old('type_place', $place->type_place) === 'reserve' ? 'selected' : '' }}>Réservée</option>
                            </select>
                            @error('type_place')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Disponible -->
                        <div class="mb-6">
                            <label for="disponible" class="flex items-center">
                                <input type="checkbox" id="disponible" name="disponible" value="1" {{ $place->disponible ? 'checked' : '' }} class="mr-2">
                                <span class="font-medium">Disponible</span>
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-between">
                            <a href="{{ route('admin') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Modifier la place
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
