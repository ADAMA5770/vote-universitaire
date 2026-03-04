<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

// Redirection racine
Route::get('/', fn () => redirect()->route('elections.index'));

// Routes pour les invités (non connectés)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // [SÉCURITÉ] Throttle : max 5 tentatives de connexion par minute par IP
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // [SÉCURITÉ] Throttle : max 5 créations de compte par minute par IP
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1');
});

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {

    // Élections (vue étudiants)
    Route::get('/elections', [ElectionController::class, 'index'])->name('elections.index');
    Route::get('/elections/{election}', [ElectionController::class, 'show'])->name('elections.show');

    // Votes
    Route::post('/elections/{election}/voter', [VoteController::class, 'voter'])->name('elections.voter');
    Route::get('/elections/{election}/resultats', [VoteController::class, 'resultats'])->name('elections.resultats');

    // Administration
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // CRUD élections (admin)
        Route::get('/elections', [ElectionController::class, 'adminIndex'])->name('elections.index');
        Route::get('/elections/create', [ElectionController::class, 'create'])->name('elections.create');
        Route::post('/elections', [ElectionController::class, 'store'])->name('elections.store');
        Route::get('/elections/{election}/edit', [ElectionController::class, 'edit'])->name('elections.edit');
        Route::put('/elections/{election}', [ElectionController::class, 'update'])->name('elections.update');
        Route::delete('/elections/{election}', [ElectionController::class, 'destroy'])->name('elections.destroy');
    });
});
