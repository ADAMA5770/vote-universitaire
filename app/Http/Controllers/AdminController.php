<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Election;
use App\Models\LogActivite;
use App\Models\Setting;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $nbElections        = Election::count();
        $nbVotes            = Vote::count();
        $nbEtudiants        = User::where('role', 'etudiant')->count();
        $nbCandidats        = Candidat::count();
        $electionsActives   = Election::where('statut', 'active')->count();
        $dernieresElections = Election::orderBy('created_at', 'desc')->take(5)->get();
        $maintenance        = Setting::get('maintenance', '0') === '1';

        // Données Chart.js : votes par élection
        $electionsChart = Election::withCount('votes')->orderBy('created_at', 'desc')->take(8)->get();
        $chartLabels    = $electionsChart->pluck('titre')->map(fn($t) => strlen($t) > 20 ? substr($t, 0, 20) . '…' : $t);
        $chartData      = $electionsChart->pluck('votes_count');

        return view('admin.dashboard', compact(
            'nbElections',
            'nbVotes',
            'nbEtudiants',
            'nbCandidats',
            'electionsActives',
            'dernieresElections',
            'maintenance',
            'chartLabels',
            'chartData'
        ));
    }

    public function toggleMaintenance(Request $request)
    {
        $current = Setting::get('maintenance', '0');
        $new     = $current === '1' ? '0' : '1';
        Setting::set('maintenance', $new);

        LogActivite::log('maintenance', 'Mode maintenance ' . ($new === '1' ? 'activé' : 'désactivé'));

        return back()->with('success', 'Mode maintenance ' . ($new === '1' ? 'activé' : 'désactivé') . '.');
    }

    public function logs()
    {
        $logs = LogActivite::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }
}
