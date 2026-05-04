<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ParkingSpace;
use App\Models\ListeAttente;
use App\Models\HistoriqueAttributions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function store()
    {
        $userId = Auth::id();

        // Vérifier doublon
        $exists = Reservation::where('user_id', $userId)
            ->where('statut', 'confirmee')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà une réservation.');
        }

        if (ListeAttente::where('user_id', $userId)->exists()) {
            return back()->with('error', 'Vous êtes déjà en file d\'attente.');
        }

        // Chercher place libre
        $place = ParkingSpace::where('disponible', true)->first();

        if ($place) {
            $place->update(['disponible' => false]);

            Reservation::create([
                'user_id' => $userId,
                'parking_space_id' => $place->id,
                'date_debut' => now(),
                'date_fin' => now()->addDays(1),
                'statut' => 'confirmee'
            ]);

            HistoriqueAttributions::create([
                'user_id' => $userId,
                'parking_space_id' => $place->id,
                'date_attribution' => now()
            ]);

            return back()->with('success', 'Place attribuée : ' . $place->numero_place);
        }

        // File d'attente
        $position = ListeAttente::max('position') ?? 0;

        ListeAttente::create([
            'user_id' => $userId,
            'position' => $position + 1,
            'date_inscription' => now()
        ]);

        return back()->with('success', 'File d\'attente position ' . ($position + 1));
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->update(['statut' => 'annulee']);
        $place = $reservation->parking_space;

        // Prochain en attente
        $next = ListeAttente::orderBy('position')->first();

        if ($next) {
            $place->update(['disponible' => false]);

            Reservation::create([
                'user_id' => $next->user_id,
                'parking_space_id' => $place->id,
                'date_debut' => now(),
                'date_fin' => now()->addDays(1),
                'statut' => 'confirmee'
            ]);

            HistoriqueAttributions::create([
                'user_id' => $next->user_id,
                'parking_space_id' => $place->id,
                'date_attribution' => now()
            ]);

            $next->delete();
            ListeAttente::where('position', '>', $next->position)->decrement('position');
        } else {
            $place->update(['disponible' => true]);
        }

        return back()->with('success', 'Réservation annulée.');
    }
}

