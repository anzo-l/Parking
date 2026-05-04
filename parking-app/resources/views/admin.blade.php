<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin - Parking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Places de Parking -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Places de Parking</h3>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border p-2">Numéro</th>
                                <th class="border p-2">Type</th>
                                <th class="border p-2">Disponible</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($places as $place)
                                <tr class="border">
                                    <td class="border p-2">{{ $place->numero_place }}</td>
                                    <td class="border p-2">{{ $place->type_place }}</td>
                                    <td class="border p-2">
                                        @if($place->disponible)
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Libre</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Occupée</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Réservations -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Réservations Actives</h3>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border p-2">Utilisateur</th>
                                <th class="border p-2">Place</th>
                                <th class="border p-2">Début</th>
                                <th class="border p-2">Fin</th>
                                <th class="border p-2">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $res)
                                @if($res->statut === 'confirmee')
                                    <tr class="border">
                                        <td class="border p-2">{{ $res->user->name }}</td>
                                        <td class="border p-2">{{ $res->parking_space->numero_place }}</td>
                                        <td class="border p-2">{{ $res->date_debut }}</td>
                                        <td class="border p-2">{{ $res->date_fin }}</td>
                                        <td class="border p-2">{{ $res->statut }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- File d'Attente -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">File d'Attente</h3>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border p-2">Position</th>
                                <th class="border p-2">Utilisateur</th>
                                <th class="border p-2">Date Inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($waitlist as $item)
                                <tr class="border">
                                    <td class="border p-2">{{ $item->position }}</td>
                                    <td class="border p-2">{{ $item->user->name }}</td>
                                    <td class="border p-2">{{ $item->date_inscription }}</td>
                                </tr>
                            @empty
                                <tr class="border">
                                    <td colspan="3" class="border p-2 text-center">Aucun utilisateur en attente</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
