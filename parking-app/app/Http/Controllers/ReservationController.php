<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ParkingSpace;
use App\Models\ListeAttente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Créer une réservation ou ajouter à la liste d'attente
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'Vous devez être connecté.');
        }

        // Vérifier si l'utilisateur a déjà une réservation active
        $existingReservation = Reservation::where('user_id', $user->id)
            ->where('statut', 'confirmee')
            ->first();

        if ($existingReservation) {
            return back()->with('error', 'Vous avez déjà une réservation active.');
        }

        // Chercher une place libre
        $parkingSpace = ParkingSpace::where('disponible', true)->first();

        if ($parkingSpace) {
            // Rendre la place occupée
            $parkingSpace->update(['disponible' => false]);

            // Créer la réservation
            Reservation::create([
                'user_id' => $user->id,
                'parking_space_id' => $parkingSpace->id,
                'date_debut' => now(),
                'date_fin' => now()->addDays(1),
                'statut' => 'confirmee'
            ]);

            return back()->with('success', 'Place attribuée : ' . $parkingSpace->numero_place);
        }

        // Sinon ajouter à la liste d'attente
        $position = ListeAttente::max('position') ?? 0;

        ListeAttente::create([
            'user_id' => $user->id,
            'position' => $position + 1,
            'date_inscription' => now()
        ]);

        return back()->with('success', 'Ajouté en file d\'attente position ' . ($position + 1));
    }

    /**
     * Annuler une réservation
     */
    public function cancel(Reservation $reservation)
    {
        $user = Auth::user();

        if (!$user || $reservation->user_id !== $user->id) {
            return back()->with('error', 'Vous ne pouvez pas annuler cette réservation.');
        }

        $reservation->update(['statut' => 'annulee']);
        $reservation->parking_space->update(['disponible' => true]);

        return back()->with('success', 'Réservation annulée.');
    }
}
