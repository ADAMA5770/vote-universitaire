<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifiant' => 'required|string',
            'password'    => 'required',
        ]);

        $identifiant = trim($request->identifiant);

        // Chercher l'utilisateur par email OU par numéro étudiant
        if (filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $identifiant)->first();
        } else {
            $user = User::where('numero_etudiant', $identifiant)->first();
        }

        // Vérifier l'existence et le mot de passe
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'identifiant' => 'Identifiant ou mot de passe incorrect.',
            ])->onlyInput('identifiant');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('elections.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
