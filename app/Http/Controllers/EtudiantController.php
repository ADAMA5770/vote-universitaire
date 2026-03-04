<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = User::where('role', 'etudiant')->orderBy('name')->get();

        return view('admin.etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('admin.etudiants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'numero_etudiant'  => 'required|string|max:50|unique:users,numero_etudiant',
            'email'            => 'required|email|max:255|unique:users,email',
            'password'         => 'required|string|min:6',
        ]);

        // [SÉCURITÉ] Protection XSS sur les champs texte
        User::create([
            'name'            => strip_tags($validated['name']),
            'numero_etudiant' => strip_tags($validated['numero_etudiant']),
            'email'           => $validated['email'],
            'password'        => Hash::make($validated['password']),
            'role'            => 'etudiant',
        ]);

        return redirect()->route('admin.etudiants.index')
            ->with('success', "Compte étudiant créé pour « {$validated['name']} ».");
    }

    public function destroy(User $user)
    {
        // [SÉCURITÉ] Ne pas supprimer un admin ou soi-même
        if ($user->isAdmin()) {
            return back()->with('error', 'Impossible de supprimer un compte administrateur.');
        }

        $nom = $user->name;
        $user->delete();

        return redirect()->route('admin.etudiants.index')
            ->with('success', "Compte de « {$nom} » supprimé.");
    }
}
