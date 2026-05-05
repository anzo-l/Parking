<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ParkingSpace;
use App\Models\Reservation;
use App\Models\ListeAttente;
use App\Models\HistoriqueAttributions;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->get();
        $places = ParkingSpace::with('users')->get();
        $reservations = Reservation::with(['user', 'parking_space'])->get();
        $waitlist = ListeAttente::with('user')->orderBy('position')->get();
        $historique = HistoriqueAttributions::with(['user', 'parking_space'])
            ->orderBy('date_debut', 'desc')->get();

        return view('admin', [
            'users' => $users,
            'places' => $places,
            'reservations' => $reservations,
            'waitlist' => $waitlist,
            'historique' => $historique,
        ]);
    }

    // GESTION UTILISATEURS
    public function create_user()
    {
        return view('admin.user.create');
    }

    public function store_user(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'is_admin' => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        return redirect()->route('admin')->with('success', 'Utilisateur créé avec succès');
    }

    public function edit_user($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', ['user' => $user]);
    }

    public function update_user(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'is_admin' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('admin')->with('success', 'Utilisateur modifié avec succès');
    }

    public function delete_user($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin')->with('success', 'Utilisateur supprimé avec succès');
    }

    // GESTION PLACES DE PARKING
    public function create_parking()
    {
        return view('admin.parking.create');
    }

    public function store_parking(Request $request)
    {
        $validated = $request->validate([
            'numero_place' => 'required|string|unique:parking_spaces',
            'type_place' => 'required|in:normal,pmr,reserve',
            'disponible' => 'boolean',
        ]);

        ParkingSpace::create($validated);
        return redirect()->route('admin')->with('success', 'Place de parking créée');
    }

    public function edit_parking($id)
    {
        $place = ParkingSpace::findOrFail($id);
        return view('admin.parking.edit', ['place' => $place]);
    }

    public function update_parking(Request $request, $id)
    {
        $place = ParkingSpace::findOrFail($id);
        
        $validated = $request->validate([
            'numero_place' => 'required|string|unique:parking_spaces,numero_place,' . $id,
            'type_place' => 'required|in:normal,pmr,reserve',
            'disponible' => 'boolean',
        ]);

        $place->update($validated);
        return redirect()->route('admin')->with('success', 'Place modifiée');
    }

    public function delete_parking($id)
    {
        $place = ParkingSpace::findOrFail($id);
        $place->delete();
        
        return redirect()->route('admin')->with('success', 'Place supprimée');
    }

    // GESTION FILE D'ATTENTE
    public function remove_from_waitlist($id)
    {
        $waitlist = ListeAttente::findOrFail($id);
        $oldPosition = $waitlist->position;
        $waitlist->delete();

        // Réorganiser les positions
        ListeAttente::where('position', '>', $oldPosition)->decrement('position');

        return redirect()->route('admin')->with('success', 'Utilisateur retiré de la file d\'attente');
    }

    public function promote_from_waitlist($id)
    {
        $waitlist = ListeAttente::findOrFail($id);
        $user = $waitlist->user;
        
        // Trouver une place libre
        $place = ParkingSpace::where('disponible', true)->first();
        
        if (!$place) {
            return redirect()->route('admin')->with('error', 'Aucune place disponible');
        }

        // Assigner la place à l'utilisateur
        $user->update(['current_parking_space_id' => $place->id]);
        $place->update(['disponible' => false]);

        // Enregistrer dans l'historique
        HistoriqueAttributions::create([
            'utilisateur_id' => $user->id,
            'parking_space_id' => $place->id,
            'date_debut' => now(),
        ]);

        // Retirer de la file d'attente
        $oldPosition = $waitlist->position;
        $waitlist->delete();
        ListeAttente::where('position', '>', $oldPosition)->decrement('position');

        return redirect()->route('admin')->with('success', 'Utilisateur promu et place assignée');
    }
}
