<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:patient,medecin,admin'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        if ($request->role === 'patient') {
            \App\Models\Patient::create([
                'user_id' => $user->id,
                'nom' => $request->name,
                'prenom' => '',
                'telephone' => '',
                'date_naissance' => null
            ]);
        }

        if ($request->role === 'medecin') {
            \App\Models\Medecin::create([
                'user_id' => $user->id,
                'nom' => $request->name,
                'prenom' => '',
                'specialite' => 'generaliste',
                'telephone' => '',
                'emailPro' => null,
                'horaires_disponibles' => null,
                'categorie' => null,
                'experience' => null,
                'statut_dispo' => 'disponible',
                'first_login' => true
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
