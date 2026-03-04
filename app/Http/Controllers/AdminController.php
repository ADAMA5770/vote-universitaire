<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use App\Models\Vote;

class AdminController extends Controller
{
    public function dashboard()
    {
        $nbElections      = Election::count();
        $nbVotes          = Vote::count();
        $nbEtudiants      = User::where('role', 'etudiant')->count();
        $electionsActives = Election::where('statut', 'active')->count();
        $dernieresElections = Election::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'nbElections',
            'nbVotes',
            'nbEtudiants',
            'electionsActives',
            'dernieresElections'
        ));
    }
}
