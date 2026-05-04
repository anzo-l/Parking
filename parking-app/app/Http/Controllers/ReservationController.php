<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ParkingSpace;
use App\Models\ListeAttente;
use App\Models\HistoriqueAttributions;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store()
    {
        $userId = Auth::id();

        // Vérifier réservation active
        $existingReservation = Reservation::where('user_id', $userId)
            ->where('statut', 'confirmee')
            ->first();

        if ($existingReservation) {
            return back()->with('error', 'Vous avez déjà une réservation active.');
        }

        // Vérifier si en liste d'attente
        $inWaitList = ListeAttente::where('user_id', $userId)->exists();

        if ($inWaitList) {
            return back()->with('error', 'Vous êtes déjà en file d\'attente.');
        }

        // Chercher place libre
        $parkingSpace = ParkingSpace::where('disponible', true)->first();

        if ($parkingSpace) {
            $parkingSpace->update(['disponible' => false]);

            Reservation::create([
                'user_id' => $userId,
                'parking_space_id' => $parkingSpace->id,
                'date_debut' => now(),
                'date_fin' => now()->addDays(1),
                'statut' => 'confirmee'
            ]);

            HistoriqueAttributions::create([
                'user_id' => $userId,
                'parking_space_id' => $parkingSpace->id,
                'date_attribution' => now()
            ]);

            return back()->with('success', 'Place attribuée : ' . $parkingSpace->numero_place);
        }

        // Ajouter à liste attente
        $position = ListeAttente::max('position') ?? 0;

        ListeAttente::create([
            'user_id' => $userId,
            'position' => $position + 1,
            'date_inscription' => now()
        ]);

        return back()->with('success', 'Ajouté en file d\'attente position ' . ($position + 1));
    }

    public function cancel(Reservation $reservation)
    {
        $userId = Auth::id();

        if ($reservation->user_id !== $userId) {
            return back()->with('error', 'Non autorisé.');
        }

        $reservation->update(['statut' => 'annulee']);
        $parkingSpace = $reservation->parking_space;

        // Récupérer première personne en attente
        $nextUser = ListeAttente::orderBy('position')->first();

        if ($nextUser) {
            $parkingSpace->update(['disponible' => false]);

            Reservation::create([
                'user_id' => $nextUser->user_id,
                'parking_space_id' => $parkingSpace->id,
                'date_debut' => now(),
                'date_fin' => now()->addDays(1),
                'statut' => 'confirmee'
            ]);

            HistoriqueAttributions::create([
                'user_id' => $nextUser->user_id,
                'parking_space_id' => $parkingSpace->id,
                'date_attribution' => now()
            ]);

            $nextUser->delete();

            ListeAttente::where('position', '>', $nextUser->position)
                ->decrement('position');
        } else {
            $parkingSpace->update(['disponible' => true]);
        }

        return back()->with('success', 'Réservation annulée.');
    }
}
