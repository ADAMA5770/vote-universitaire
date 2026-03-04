<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Election;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    public function store(Request $request, Election $election)
    {
        $validated = $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'programme' => 'nullable|string|max:1000',
        ]);

        // [SÉCURITÉ] Protection XSS
        $validated['nom']       = strip_tags($validated['nom']);
        $validated['prenom']    = strip_tags($validated['prenom']);
        $validated['programme'] = isset($validated['programme']) ? strip_tags($validated['programme']) : null;
        $validated['election_id'] = $election->id;

        Candidat::create($validated);

        return redirect()->route('admin.elections.edit', $election)
            ->with('success', "Candidat « {$validated['prenom']} {$validated['nom']} » ajouté avec succès.");
    }

    public function destroy(Candidat $candidat)
    {
        // [SÉCURITÉ] Interdire la suppression si l'élection a déjà des votes
        if ($candidat->election->votes()->count() > 0) {
            return back()->with('error',
                "Impossible de supprimer ce candidat : l'élection a déjà des votes enregistrés.");
        }

        $election = $candidat->election;
        $nom = "{$candidat->prenom} {$candidat->nom}";
        $candidat->delete();

        return redirect()->route('admin.elections.edit', $election)
            ->with('success', "Candidat « {$nom} » supprimé.");
    }
}
