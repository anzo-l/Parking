<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $user = Auth::user();

        // Vérifier si l'utilisateur a déjà une place assignée
        if ($user->current_parking_space_id) {
            return back()->with('error', 'Vous avez déjà une place de parking assignée.');
        }

        // Vérifier doublon réservation
        $existingReservation = Reservation::where('user_id', $userId)
            ->where('statut', 'confirmee')
            ->exists();

        if ($existingReservation) {
            return back()->with('error', 'Vous avez déjà une réservation.');
        }

        // Vérifier si déjà en file d'attente
        if (ListeAttente::where('user_id', $userId)->exists()) {
            return back()->with('error', 'Vous êtes déjà en file d\'attente.');
        }

        // Chercher place libre
        $place = ParkingSpace::where('disponible', true)->first();

        if ($place) {
            // Assigner la place directement à l'utilisateur
            User::find($userId)->update(['current_parking_space_id' => $place->id]);
            $place->update(['disponible' => false]);

            // Créer une réservation
            Reservation::create([
                'user_id' => $userId,
                'parking_space_id' => $place->id,
                'date_debut' => now(),
                'date_fin' => now()->addDays(30),
                'statut' => 'confirmee'
            ]);

            // Enregistrer dans l'historique
            HistoriqueAttributions::create([
                'utilisateur_id' => $userId,
                'parking_space_id' => $place->id,
                'date_debut' => now()
            ]);

            return back()->with('success', 'Félicitations ! Place attribuée : ' . $place->numero_place);
        }

        // File d'attente si aucune place disponible
        $position = ListeAttente::max('position') ?? 0;

        ListeAttente::create([
            'user_id' => $userId,
            'position' => $position + 1,
            'date_inscription' => now()
        ]);

        return back()->with('success', 'Aucune place disponible. Vous êtes en file d\'attente à la position ' . ($position + 1));
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $user = $reservation->user;
        $place = $reservation->parking_space;

        // Mettre à jour l'historique (date fin)
        $historique = HistoriqueAttributions::where('utilisateur_id', $user->id)
            ->where('parking_space_id', $place->id)
            ->orderBy('date_debut', 'desc')
            ->first();

        if ($historique) {
            $historique->update(['date_fin' => now()]);
        }

        // Libérer la place de l'utilisateur
        User::find($user->id)->update(['current_parking_space_id' => null]);
        $reservation->update(['statut' => 'annulee']);

        // Prochain en attente
        $next = ListeAttente::orderBy('position')->first();

        if ($next) {
            $nextUser = $next->user;

            // Assigner la place au prochain
            User::find($next->user_id)->update(['current_parking_space_id' => $place->id]);

            // Créer une réservation pour le prochain
            Reservation::create([
                'user_id' => $next->user_id,
                'parking_space_id' => $place->id,
                'date_debut' => now(),
                'date_fin' => now()->addDays(30),
                'statut' => 'confirmee'
            ]);

            // Enregistrer dans l'historique
            HistoriqueAttributions::create([
                'utilisateur_id' => $next->user_id,
                'parking_space_id' => $place->id,
                'date_debut' => now()
            ]);

            // Retirer de la file d'attente et réorganiser
            $oldPosition = $next->position;
            $next->delete();
            ListeAttente::where('position', '>', $oldPosition)->decrement('position');

            return back()->with('success', 'Réservation annulée. La prochaine personne en file d\'attente a reçu la place.');
        } else {
            // Si pas de file d'attente, libérer la place
            $place->update(['disponible' => true]);
            return back()->with('success', 'Réservation annulée.');
        }
    }

    public function cancelWaitlist($id)
    {
        $waitlist = ListeAttente::findOrFail($id);

        if ($waitlist->user_id !== Auth::id()) {
            abort(403);
        }

        $oldPosition = $waitlist->position;
        $waitlist->delete();

        // Réorganiser les positions
        ListeAttente::where('position', '>', $oldPosition)->decrement('position');

        return back()->with('success', 'Vous avez quitté la file d\'attente.');
    }
}

