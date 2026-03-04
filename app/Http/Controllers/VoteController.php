<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function voter(Request $request, Election $election)
    {
        // [SÉCURITÉ] Vérifier que l'élection est active
        if ($election->statut !== 'active') {
            return back()->with('error', "Cette élection n'est pas active et n'accepte plus de votes.");
        }

        // [SÉCURITÉ] Vérifier que l'étudiant n'a pas déjà voté (vérification applicative)
        $aDejaVote = Auth::user()->votes()->where('election_id', $election->id)->exists();
        if ($aDejaVote) {
            return back()->with('error', 'Vous avez déjà voté pour cette élection.');
        }

        $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
        ]);

        // [SÉCURITÉ] Vérifier que le candidat appartient bien à cette élection (évite la manipulation d'ID)
        $candidat = $election->candidats()->findOrFail($request->candidat_id);

        try {
            Vote::create([
                'election_id' => $election->id,
                'candidat_id' => $candidat->id,
                'user_id'     => Auth::id(),
                'voted_at'    => now(),
            ]);
        } catch (QueryException $e) {
            // [SÉCURITÉ] Protection contre les race conditions (double clic / double requête simultanée)
            // La contrainte UNIQUE (election_id, user_id) en BDD bloque le double vote même si la
            // vérification applicative ci-dessus passe deux fois en parallèle.
            return back()->with('error', 'Vous avez déjà voté pour cette élection.');
        }

        return redirect()->route('elections.resultats', $election)
            ->with('success', 'Votre vote a été enregistré avec succès !');
    }

    public function resultats(Election $election)
    {
        // [SÉCURITÉ] Un étudiant ne peut voir les résultats que :
        //   - s'il a déjà voté dans cette élection (résultats provisoires)
        //   - OU si l'élection est terminée (résultats définitifs)
        if (!Auth::user()->isAdmin()) {
            $aVote = Auth::user()->votes()->where('election_id', $election->id)->exists();
            if (!$aVote && $election->statut !== 'terminee') {
                return redirect()->route('elections.show', $election)
                    ->with('error', 'Vous devez voter avant de consulter les résultats provisoires.');
            }
        }

        $election->load('candidats.votes');
        $totalVotes = $election->votes()->count();

        $candidats = $election->candidats->map(function ($candidat) use ($totalVotes) {
            $nbVotes     = $candidat->votes->count();
            $pourcentage = $totalVotes > 0 ? round(($nbVotes / $totalVotes) * 100, 1) : 0;

            return [
                'nom'         => $candidat->prenom . ' ' . $candidat->nom,
                'nb_votes'    => $nbVotes,
                'pourcentage' => $pourcentage,
            ];
        })->sortByDesc('nb_votes')->values();

        return view('elections.resultats', compact('election', 'candidats', 'totalVotes'));
    }
}
