<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ListeAttente;
use App\Models\HistoriqueAttributions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Récupérer place actuelle assignée
        $currentParking = $user->parking_space;

        // Récupérer réservation active (ancienne logique conservée)
        $reservation = Reservation::where('user_id', $userId)
            ->where('statut', 'confirmee')
            ->first();

        if ($reservation) {
            $reservation->load('parking_space');
        }

        // Récupérer position en attente
        $waitlistEntry = ListeAttente::where('user_id', $userId)->first();
        $position = $waitlistEntry?->position;

        // Récupérer historique des attributions
        $historique = HistoriqueAttributions::where('utilisateur_id', $userId)
            ->with('parking_space')
            ->orderBy('date_debut', 'desc')
            ->get();

        return view('dashboard', [
            'currentParking' => $currentParking,
            'reservation' => $reservation,
            'position' => $position,
            'waitlistEntry' => $waitlistEntry,
            'historique' => $historique,
        ]);
    }
}


