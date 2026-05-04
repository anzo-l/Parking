<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ListeAttente;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;

        // Récupérer réservation active
        $reservation = Reservation::where('user_id', $userId)
            ->where('statut', 'confirmee')
            ->first();

        // Charger la place associée si réservation existe
        if ($reservation) {
            $reservation->load('parking_space');
        }

        // Récupérer position en attente
        $position = ListeAttente::where('user_id', $userId)->first()?->position;

        return view('dashboard', [
            'reservation' => $reservation,
            'position' => $position,
        ]);
    }
}

