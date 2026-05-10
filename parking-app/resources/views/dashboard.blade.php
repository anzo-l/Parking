<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Parking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if(auth()->user()?->is_admin)
                <div class="bg-parking-primary-blue text-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h3 class="text-xl font-semibold">👑 Espace Administrateur</h3>
                                <p class="text-sm text-white/80 mt-2">Accédez rapidement à la gestion des utilisateurs, des places, de la file d'attente et de l'historique.</p>
                            </div>
                            <a href="{{ route('admin') }}" class="inline-flex items-center justify-center bg-white text-parking-primary-blue font-bold py-2 px-5 rounded-full shadow-sm hover:bg-gray-100 transition">
                                Aller à l'administration
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Place Actuelle Assignée -->
            @if($currentParking)
                <div class="bg-blue-100 dark:bg-blue-900 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-blue-900 dark:text-blue-100">
                        <h3 class="text-lg font-semibold mb-4">🅿️ Votre Place de Parking Assignée</h3>
                        <p class="mb-2"><strong>Numéro :</strong> <span class="text-2xl font-bold">{{ $currentParking->numero_place }}</span></p>
                        <p class="mb-2"><strong>Type :</strong> 
                            <span class="px-2 py-1 rounded text-white text-sm 
                                {{ $currentParking->type_place === 'pmr' ? 'bg-green-500' : ($currentParking->type_place === 'reserve' ? 'bg-purple-500' : 'bg-gray-500') }}">
                                {{ ucfirst($currentParking->type_place) }}
                            </span>
                        </p>
                    </div>
                </div>
            @endif

            <!-- Réservation Active -->
            @if($reservation)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">📅 Votre Réservation</h3>
                        <p class="mb-2"><strong>Place :</strong> {{ $reservation->parking_space->numero_place }}</p>
                        <p class="mb-2"><strong>Début :</strong> {{ $reservation->date_debut }}</p>
                        <p class="mb-4"><strong>Fin :</strong> {{ $reservation->date_fin }}</p>
                        
                        <form method="POST" action="{{ route('reservation.cancel', $reservation) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                ✗ Annuler ma Réservation
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($position)
                <div class="bg-yellow-100 dark:bg-yellow-900 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-yellow-900 dark:text-yellow-100">
                        <h3 class="text-lg font-semibold mb-2">⏳ Vous êtes en File d'Attente</h3>
                        <p class="mb-4"><strong>Position :</strong> <span class="text-2xl font-bold">{{ $position }}</span></p>
                        <p class="text-sm">Vous serez notifié quand une place devient disponible.</p>
                        
                        @if($waitlistEntry && $waitlistEntry->date_inscription)
                            <p class="text-sm mt-2"><strong>Date de demande :</strong> 
                                @if(is_string($waitlistEntry->date_inscription))
                                    {{ \Carbon\Carbon::parse($waitlistEntry->date_inscription)->format('d/m/Y H:i') }}
                                @else
                                    {{ $waitlistEntry->date_inscription->format('d/m/Y H:i') }}
                                @endif
                            </p>
                        @endif

                        <form method="POST" action="{{ route('reservation.cancel-waitlist', $waitlistEntry->id ?? 0) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir quitter la file d\'attente ?')" class="mt-4">
                            @csrf
                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                Quitter la file d'attente
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Bouton Demander Place -->
            @if(!$reservation && !$position && !$currentParking)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-6">🚗 Demander une Place de Parking</h3>
                        <p class="mb-4 text-gray-600 dark:text-gray-400">
                            Vous n'avez pas encore de place assignée. Cliquez sur le bouton ci-dessous pour faire une demande. 
                            S'il y a des places disponibles, vous en recevrez une immédiatement. Sinon, vous serez mis en file d'attente.
                        </p>
                        
                        <form method="POST" action="{{ route('reservation.store') }}">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                ✓ Demander une Place
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($currentParking)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">ℹ️ Informations</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Vous avez actuellement une place de parking assignée. Vous ne pouvez pas demander une autre place pour le moment.
                        </p>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">ℹ️ Statut</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Vous avez déjà une réservation ou êtes en file d'attente. Vous ne pouvez pas faire une nouvelle demande pour le moment.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Historique des Attributions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">📋 Historique de vos Attributions</h3>
                    
                    @if($historique && count($historique) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2">Place N°</th>
                                        <th class="px-4 py-2">Type</th>
                                        <th class="px-4 py-2">Date Début</th>
                                        <th class="px-4 py-2">Date Fin</th>
                                        <th class="px-4 py-2">Durée</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historique as $entry)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-2 font-bold text-parking-primary-blue">
                                                {{ $entry->parking_space->numero_place }}
                                            </td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 rounded text-white text-xs 
                                                    {{ $entry->parking_space->type_place === 'pmr' ? 'bg-green-500' : ($entry->parking_space->type_place === 'reserve' ? 'bg-purple-500' : 'bg-gray-500') }}">
                                                    {{ ucfirst($entry->parking_space->type_place) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">
                                                @if(is_string($entry->date_debut))
                                                    {{ \Carbon\Carbon::parse($entry->date_debut)->format('d/m/Y H:i') }}
                                                @else
                                                    {{ $entry->date_debut->format('d/m/Y H:i') }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-2">
                                                @if($entry->date_fin)
                                                    @if(is_string($entry->date_fin))
                                                        {{ \Carbon\Carbon::parse($entry->date_fin)->format('d/m/Y H:i') }}
                                                    @else
                                                        {{ $entry->date_fin->format('d/m/Y H:i') }}
                                                    @endif
                                                @else
                                                    <span class="text-gray-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2">
                                                @if($entry->date_fin)
                                                    @php
                                                        $start = is_string($entry->date_debut) ? \Carbon\Carbon::parse($entry->date_debut) : $entry->date_debut;
                                                        $end = is_string($entry->date_fin) ? \Carbon\Carbon::parse($entry->date_fin) : $entry->date_fin;
                                                        $days = $end->diffInDays($start);
                                                    @endphp
                                                    {{ $days }} jour(s)
                                                @else
                                                    <span class="text-gray-500">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">
                            Aucune attribution antérieure. Vous n'avez pas encore eu de place de parking assignée.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
