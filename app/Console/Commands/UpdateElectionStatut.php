<?php

namespace App\Console\Commands;

use App\Models\Election;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateElectionStatut extends Command
{
    protected $signature = 'elections:update-statut';
    protected $description = 'Met à jour automatiquement le statut des élections selon leurs dates';

    public function handle(): int
    {
        $now = Carbon::now();

        // Active : date_debut <= maintenant <= date_fin
        $nbActive = Election::where('date_debut', '<=', $now)
            ->where('date_fin', '>=', $now)
            ->where('statut', '!=', 'active')
            ->update(['statut' => 'active']);

        // Terminée : date_fin < maintenant
        $nbTerminee = Election::where('date_fin', '<', $now)
            ->where('statut', '!=', 'terminee')
            ->update(['statut' => 'terminee']);

        // En attente : date_debut > maintenant
        $nbAttente = Election::where('date_debut', '>', $now)
            ->where('statut', '!=', 'en_attente')
            ->update(['statut' => 'en_attente']);

        $this->info("Statuts mis à jour : {$nbActive} active(s), {$nbTerminee} terminée(s), {$nbAttente} en attente.");

        return Command::SUCCESS;
    }
}
