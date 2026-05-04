<?php

namespace App\Http\Controllers;

use App\Models\ListeAttente;
use Illuminate\Http\Request;

class ListeAttenteController extends Controller
{
    /**
     * Afficher la liste d'attente
     */
    public function index()
    {
        $listAttente = ListeAttente::with('user')
            ->orderBy('position')
            ->get();
        return response()->json($listAttente);
    }

    /**
     * Ajouter un utilisateur à la liste d'attente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:liste_attentes,user_id',
        ]);

        // Obtenir la dernière position
        $lastPosition = ListeAttente::max('position') ?? 0;

        $listAttente = ListeAttente::create([
            'user_id' => $validated['user_id'],
            'position' => $lastPosition + 1,
            'date_inscription' => now(),
        ]);

        return response()->json($listAttente, 201);
    }

    /**
     * Afficher un utilisateur de la liste d'attente
     */
    public function show(ListeAttente $listeAttente)
    {
        return response()->json($listeAttente->load('user'));
    }

    /**
     * Retirer un utilisateur de la liste d'attente
     */
    public function destroy(ListeAttente $listeAttente)
    {
        $position = $listeAttente->position;
        $listeAttente->delete();

        // Réajuster les positions des utilisateurs après celui supprimé
        ListeAttente::where('position', '>', $position)
            ->decrement('position');

        return response()->json(['message' => 'Utilisateur retiré de la liste d\'attente']);
    }

    /**
     * Passer au prochain utilisateur dans la liste d'attente
     */
    public function nextUser()
    {
        $nextUser = ListeAttente::where('position', 1)->first();

        if (!$nextUser) {
            return response()->json(['message' => 'Aucun utilisateur en attente'], 404);
        }

        // Supprimer l'utilisateur et réajuster les positions
        $nextUser->delete();
        ListeAttente::decrement('position');

        return response()->json([
            'message' => 'Prochain utilisateur appelé',
            'user_id' => $nextUser->user_id,
        ]);
    }
}
