<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\Election;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Utilisateurs ──────────────────────────────────────────────────────
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@vote.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Étudiant Test',
            'email'    => 'etudiant@vote.com',
            'password' => Hash::make('etudiant123'),
            'role'     => 'etudiant',
        ]);

        // ── Élection 1 : Active ───────────────────────────────────────────────
        $election1 = Election::create([
            'titre'       => 'Élection du Président des Étudiants 2025',
            'description' => 'Votez pour votre représentant étudiant pour l\'année académique 2025-2026. '
                           . 'Chaque vote compte pour l\'avenir de notre université.',
            'date_debut'  => Carbon::now()->subDay(),
            'date_fin'    => Carbon::now()->addDays(7),
            'statut'      => 'active',
        ]);

        Candidat::insert([
            [
                'election_id' => $election1->id,
                'nom'         => 'MBONGO',
                'prenom'      => 'Jean-Paul',
                'photo'       => null,
                'programme'   => 'Améliorer les conditions d\'études, renforcer les activités culturelles '
                               . 'et créer un espace de détente pour les étudiants.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'election_id' => $election1->id,
                'nom'         => 'NTOTO',
                'prenom'      => 'Marie-Claire',
                'photo'       => null,
                'programme'   => 'Digitaliser les services universitaires, créer un espace coworking '
                               . 'étudiant et améliorer la connexion Wi-Fi sur le campus.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'election_id' => $election1->id,
                'nom'         => 'KIMBWALA',
                'prenom'      => 'David',
                'photo'       => null,
                'programme'   => 'Négocier une réduction des frais d\'inscription, améliorer le système '
                               . 'de bourses et défendre les droits des étudiants.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // ── Élection 2 : En attente ───────────────────────────────────────────
        $election2 = Election::create([
            'titre'       => 'Élection du Délégué de Classe — L3 GL',
            'description' => 'Choisissez votre délégué de classe pour le second semestre. '
                           . 'Le délégué sera le lien entre les étudiants et l\'administration.',
            'date_debut'  => Carbon::now()->addDays(3),
            'date_fin'    => Carbon::now()->addDays(10),
            'statut'      => 'en_attente',
        ]);

        Candidat::insert([
            [
                'election_id' => $election2->id,
                'nom'         => 'LUZOLO',
                'prenom'      => 'Patrick',
                'photo'       => null,
                'programme'   => 'Organiser des sessions de révision collectives hebdomadaires '
                               . 'et améliorer la communication avec les enseignants.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'election_id' => $election2->id,
                'nom'         => 'MVIOKI',
                'prenom'      => 'Espérance',
                'photo'       => null,
                'programme'   => 'Mettre en place une plateforme de partage de cours et de ressources '
                               . 'pédagogiques accessibles à tous les étudiants.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'election_id' => $election2->id,
                'nom'         => 'NSIMBA',
                'prenom'      => 'Christian',
                'photo'       => null,
                'programme'   => 'Créer un groupe de travail pour les projets de fin d\'études '
                               . 'et faciliter l\'accès aux stages professionnels.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
