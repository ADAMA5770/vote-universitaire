<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\LogActivite;
use App\Models\Vote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    public function voter(Request $request, Election $election)
    {
        // [SÉCURITÉ] Seuls les comptes étudiants peuvent voter (pas les admins)
        if (Auth::user()->role !== 'etudiant') {
            return back()->with('error', 'Seuls les étudiants peuvent participer aux votes.');
        }

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
            return back()->with('error', 'Vous avez déjà voté pour cette élection.');
        }

        LogActivite::log('vote', "Vote pour « {$candidat->prenom} {$candidat->nom} » dans « {$election->titre} »");

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

        [$candidats, $totalVotes] = $this->buildResultats($election);

        return view('elections.resultats', compact('election', 'candidats', 'totalVotes'));
    }

    public function exportPdf(Election $election)
    {
        // Même contrôle d'accès que resultats()
        if (!Auth::user()->isAdmin()) {
            $aVote = Auth::user()->votes()->where('election_id', $election->id)->exists();
            if (!$aVote && $election->statut !== 'terminee') {
                return redirect()->route('elections.show', $election)
                    ->with('error', 'Vous devez voter avant de consulter les résultats.');
            }
        }

        [$candidats, $totalVotes] = $this->buildResultats($election);

        $pdf = Pdf::loadView('elections.resultats-pdf', compact('election', 'candidats', 'totalVotes'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('resultats-' . Str::slug($election->titre) . '.pdf');
    }

    public function historique()
    {
        $votes = Auth::user()->votes()
            ->with(['election', 'candidat'])
            ->orderBy('voted_at', 'desc')
            ->get();

        return view('etudiant.historique', compact('votes'));
    }

    public function bulletinPdf(Election $election)
    {
        // Seuls les étudiants ayant voté dans cette élection peuvent télécharger leur bulletin
        $vote = Auth::user()->votes()
            ->where('election_id', $election->id)
            ->with(['candidat', 'user'])
            ->first();

        if (!$vote) {
            return redirect()->route('elections.show', $election)
                ->with('error', 'Vous devez voter pour obtenir un bulletin.');
        }

        $hash = substr(hash('sha256', $vote->user_id . $vote->election_id . $vote->voted_at), 0, 12);

        $pdf = Pdf::loadView('elections.bulletin-pdf', compact('election', 'vote', 'hash'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('bulletin-vote-' . Str::slug($election->titre) . '.pdf');
    }

    // Méthode partagée : construit le tableau des résultats
    private function buildResultats(Election $election): array
    {
        $election->load('candidats.votes');
        $totalVotes = $election->votes()->count();

        $candidats = $election->candidats->map(function ($candidat) use ($totalVotes) {
            $nbVotes     = $candidat->votes->count();
            $pourcentage = $totalVotes > 0 ? round(($nbVotes / $totalVotes) * 100, 1) : 0;

            return [
                'nom'         => $candidat->prenom . ' ' . $candidat->nom,
                'photo'       => $candidat->photo,
                'nb_votes'    => $nbVotes,
                'pourcentage' => $pourcentage,
            ];
        })->sortByDesc('nb_votes')->values();

        return [$candidats, $totalVotes];
    }
}
