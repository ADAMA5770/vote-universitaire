<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
    // Pour les étudiants : liste uniquement les élections actives
    public function index()
    {
        $elections = Election::where('statut', 'active')->get();

        return view('elections.index', compact('elections'));
    }

    // Pour les étudiants : affiche le détail + formulaire de vote
    public function show(Election $election)
    {
        // [SÉCURITÉ] Un étudiant ne peut accéder qu'aux élections actives
        if (!Auth::user()->isAdmin() && $election->statut !== 'active') {
            return redirect()->route('elections.index')
                ->with('error', "Cette élection n'est pas accessible.");
        }

        $election->load('candidats');
        $aDejaVote = Auth::user()->votes()->where('election_id', $election->id)->exists();

        return view('elections.show', compact('election', 'aDejaVote'));
    }

    // Pour l'admin : liste toutes les élections
    public function adminIndex()
    {
        $elections = Election::orderBy('created_at', 'desc')->get();

        return view('admin.elections.index', compact('elections'));
    }

    public function create()
    {
        return view('admin.elections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'date_debut'  => 'required|date',
            'date_fin'    => 'required|date|after:date_debut',
            'statut'      => 'required|in:en_attente,active,terminee',
        ]);

        $validated['titre']       = strip_tags($validated['titre']);
        $validated['description'] = isset($validated['description']) ? strip_tags($validated['description']) : null;

        Election::create($validated);

        return redirect()->route('admin.elections.index')
            ->with('success', 'Élection créée avec succès.');
    }

    public function edit(Election $election)
    {
        // [SÉCURITÉ] Impossible de modifier une élection active (votes en cours)
        if ($election->statut === 'active') {
            return redirect()->route('admin.elections.index')
                ->with('error', "Impossible de modifier « {$election->titre} » : l'élection est active. Clôturez-la d'abord.");
        }

        $election->load('candidats');

        return view('admin.elections.edit', compact('election'));
    }

    public function update(Request $request, Election $election)
    {
        // [SÉCURITÉ] Double vérification côté serveur
        if ($election->statut === 'active') {
            return redirect()->route('admin.elections.index')
                ->with('error', "Impossible de modifier une élection active.");
        }

        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'date_debut'  => 'required|date',
            'date_fin'    => 'required|date|after:date_debut',
            'statut'      => 'required|in:en_attente,active,terminee',
        ]);

        $validated['titre']       = strip_tags($validated['titre']);
        $validated['description'] = isset($validated['description']) ? strip_tags($validated['description']) : null;

        $election->update($validated);

        return redirect()->route('admin.elections.index')
            ->with('success', 'Élection mise à jour avec succès.');
    }

    public function destroy(Election $election)
    {
        // [SÉCURITÉ] Règle métier : interdire la suppression si des votes ont déjà été enregistrés
        $nbVotes = $election->votes()->count();
        if ($nbVotes > 0) {
            return redirect()->route('admin.elections.index')
                ->with('error', "Impossible de supprimer « {$election->titre} » : "
                    . "{$nbVotes} vote(s) ont déjà été enregistrés. Clôturez l'élection à la place.");
        }

        $election->delete();

        return redirect()->route('admin.elections.index')
            ->with('success', 'Élection supprimée avec succès.');
    }
}
