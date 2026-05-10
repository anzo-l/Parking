<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin - Gestion Parking') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- BARRE DE NAVIGATION ADMIN -->
            <nav class="bg-white border border-gray-200 shadow-sm rounded-lg mb-6">
                <div class="flex flex-wrap items-center justify-between gap-2 px-4 py-3">
                    <div class="text-sm font-semibold text-gray-700">
                        Administration
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="switchTab('users')" class="tab-btn active px-4 py-3 text-sm font-semibold rounded-lg text-white" id="btn-users">
                            👥 Gestion d'Utilisateurs
                        </button>
                        <button onclick="switchTab('parking')" class="tab-btn px-4 py-3 text-sm font-semibold rounded-lg text-white" id="btn-parking">
                            🅿️ Places de Parking
                        </button>
                        <button onclick="switchTab('waitlist')" class="tab-btn px-4 py-3 text-sm font-semibold rounded-lg text-white" id="btn-waitlist">
                            ⏳ Liste d'Attente
                        </button>
                        <button onclick="switchTab('history')" class="tab-btn px-4 py-3 text-sm font-semibold rounded-lg text-white" id="btn-history">
                            📋 Historique
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Messages de succès/erreur -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-b-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-b-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- GESTION UTILISATEURS -->
            <div id="users-section" class="tab-content active bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-b-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">👥 Gestion Utilisateurs</h3>
                        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Ajouter Utilisateur
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="border p-2 text-left">Nom</th>
                                    <th class="border p-2 text-left">Email</th>
                                    <th class="border p-2 text-left">Rôle</th>
                                    <th class="border p-2 text-left">Place</th>
                                    <th class="border p-2 text-left">Date Inscription</th>
                                    <th class="border p-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="border hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border p-2">{{ $user->name }}</td>
                                        <td class="border p-2">{{ $user->email }}</td>
                                        <td class="border p-2">
                                            <span class="px-2 py-1 rounded text-white text-sm {{ $user->is_admin ? 'bg-red-500' : 'bg-blue-500' }}">
                                                {{ $user->is_admin ? 'Admin' : 'Utilisateur' }}
                                            </span>
                                        </td>
                                        <td class="border p-2">
                                            {{ $user->parking_space ? $user->parking_space->numero_place : '-' }}
                                        </td>
                                        <td class="border p-2">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="border p-2 text-center space-x-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-3 rounded text-sm">
                                                ✏️ Modifier
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                                                    🗑️ Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border p-4 text-center">Aucun utilisateur</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- GESTION PLACES DE PARKING -->
            <div id="parking-section" class="tab-content hidden bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-b-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">🅿️ Gestion Places de Parking</h3>
                        <a href="{{ route('admin.parking.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Ajouter Place
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="border p-2 text-left">Numéro</th>
                                    <th class="border p-2 text-left">Type</th>
                                    <th class="border p-2 text-left">Utilisateur</th>
                                    <th class="border p-2 text-left">Statut</th>
                                    <th class="border p-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($places as $place)
                                    <tr class="border hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border p-2 font-bold">{{ $place->numero_place }}</td>
                                        <td class="border p-2">
                                            <span class="px-2 py-1 rounded text-white text-sm 
                                                {{ $place->type_place === 'pmr' ? 'bg-green-500' : ($place->type_place === 'reserve' ? 'bg-purple-500' : 'bg-gray-500') }}">
                                                {{ ucfirst($place->type_place) }}
                                            </span>
                                        </td>
                                        <td class="border p-2">
                                            {{ $place->users->first()?->name ?? '-' }}
                                        </td>
                                        <td class="border p-2">
                                            @if($place->disponible)
                                                <span class="px-2 py-1 rounded bg-green-100 text-green-800">✓ Libre</span>
                                            @else
                                                <span class="px-2 py-1 rounded bg-red-100 text-red-800">✗ Occupée</span>
                                            @endif
                                        </td>
                                        <td class="border p-2 text-center space-x-2">
                                            <a href="{{ route('admin.parking.edit', $place->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-3 rounded text-sm">
                                                ✏️ Modifier
                                            </a>
                                            <form method="POST" action="{{ route('admin.parking.destroy', $place->id) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                                                    🗑️ Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border p-4 text-center">Aucune place</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- FILE D'ATTENTE -->
            <div id="waitlist-section" class="tab-content hidden bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-b-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">⏳ File d'Attente</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="border p-2 text-left">Position</th>
                                    <th class="border p-2 text-left">Utilisateur</th>
                                    <th class="border p-2 text-left">Date Demande</th>
                                    <th class="border p-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($waitlist as $item)
                                    <tr class="border hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border p-2 font-bold text-lg">{{ $item->position }}</td>
                                        <td class="border p-2">{{ $item->user->name }}</td>
                                        <td class="border p-2">{{ $item->date_inscription->format('d/m/Y H:i') }}</td>
                                        <td class="border p-2 text-center space-x-2">
                                            <form method="POST" action="{{ route('admin.waitlist.promote', $item->id) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white py-1 px-3 rounded text-sm">
                                                    ✓ Promouvoir
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.waitlist.destroy', $item->id) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                                                    ✗ Retirer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border p-4 text-center">Aucun utilisateur en attente</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- HISTORIQUE ATTRIBUTIONS -->
            <div id="history-section" class="tab-content hidden bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-b-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">📋 Historique Attributions</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="border p-2 text-left">Utilisateur</th>
                                    <th class="border p-2 text-left">Numéro Place</th>
                                    <th class="border p-2 text-left">Date Attribution</th>
                                    <th class="border p-2 text-left">Date Fin</th>
                                    <th class="border p-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historique as $record)
                                    <tr class="border hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border p-2">{{ $record->user->name }}</td>
                                        <td class="border p-2 font-bold">{{ $record->parking_space->numero_place }}</td>
                                        <td class="border p-2">{{ $record->date_debut->format('d/m/Y H:i') }}</td>
                                        <td class="border p-2">
                                            {{ $record->date_fin ? $record->date_fin->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td class="border p-2 text-center space-x-2">
                                            <a href="{{ route('admin.historique.edit', $record->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-3 rounded text-sm">
                                                ✏️ Modifier
                                            </a>
                                            <form method="POST" action="{{ route('admin.historique.destroy', $record->id) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet historique ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                                                    🗑️ Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border p-4 text-center">Aucun historique</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPT POUR GESTION DES ONGLETS -->
    <script>
        function switchTab(tabName) {
            // Masquer tous les contenus
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => {
                content.classList.add('hidden');
            });

            // Retirer la classe active de tous les boutons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(button => {
                button.classList.remove('active', 'bg-opacity-100');
                button.style.backgroundColor = '';
            });

            // Afficher le contenu sélectionné
            const section = document.getElementById(tabName + '-section');
            if (section) {
                section.classList.remove('hidden');
            }

            // Activer le bouton cliqué
            const btn = document.getElementById('btn-' + tabName);
            if (btn) {
                btn.classList.add('active');
                btn.style.backgroundColor = 'rgba(0, 61, 122, 0.8)';
            }
        }

        // Style initial
        window.addEventListener('load', function() {
            document.getElementById('btn-users').style.backgroundColor = 'rgb(0, 61, 122)';
        });
    </script>

    <style>
        .tab-btn {
            background-color: rgba(0, 61, 122, 0.7);
            transition: all 0.3s ease;
        }

        .tab-btn:hover {
            background-color: rgba(0, 61, 122, 0.9);
        }

        .tab-btn.active {
            background-color: rgb(0, 61, 122);
            border-bottom: 4px solid white;
        }

        .tab-content {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .hidden {
            display: none;
        }
    </style>
</x-app-layout>
