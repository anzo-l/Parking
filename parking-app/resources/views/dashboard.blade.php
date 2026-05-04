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

            <!-- Réservation Active -->
            @if($reservation)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">✅ Votre Réservation</h3>
                        <p class="mb-2"><strong>Place :</strong> {{ $reservation->parking_space->numero_place }}</p>
                        <p class="mb-4"><strong>Début :</strong> {{ $reservation->date_debut }}</p>
                        
                        <form method="POST" action="{{ route('reservation.cancel', $reservation) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Annuler ma Réservation
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($position)
                <div class="bg-yellow-100 dark:bg-yellow-900 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-yellow-900 dark:text-yellow-100">
                        <h3 class="text-lg font-semibold mb-2">⏳ Vous êtes en File d'Attente</h3>
                        <p><strong>Position :</strong> {{ $position }}</p>
                    </div>
                </div>
            @endif

            <!-- Bouton Demander Place -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-6">Demander une Place de Parking</h3>
                    
                    @if(!$reservation && !$position)
                        <form method="POST" action="/reservation">
                            @csrf
                            <x-primary-button>
                                Demander une Place
                            </x-primary-button>
                        </form>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">Vous avez déjà une réservation ou êtes en file d'attente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
