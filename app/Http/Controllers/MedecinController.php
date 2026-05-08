<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\User;


class MedecinController extends Controller
{
    public function index(Request $request)
    {
        $query = Medecin::with('user');

        if ($request->filled('specialite')) {
            $query->where('specialite', $request->specialite);
        }

        $medecins = $query->get();

        return view('medecin.index', compact('medecins'));
    }
    public function create()
    {
        return view('medecin.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role'     => 'medecin',
        ]);

        Medecin::create([
            'user_id'   => $user->id,
            'nom'       => $request->name,
            'prenom'    => $request->prenom ?? '',
            'specialite' => $request->specialite ?? 'generaliste',
            'telephone' => $request->telephone ?? '',
            'statut_dispo' => 'disponible',
            'first_login'  => true,
        ]);

        return redirect()->route('medecin.index')->with('success', 'Médecin créé avec succès.');
    }
    public function show($id)
    {
        $medecin = Medecin::with('user')->findOrFail($id);

        return response()->json($medecin);
    }

    public function edit($id)
    {
        $medecin = Medecin::findOrFail($id);

        return view('medecin.edit', compact('medecin'));
    }

    public function update(Request $request, $id)
    {
        $medecin = Medecin::with('user')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'specialite' => 'required|string',
            'telephone' => 'required|string',
            'emailPro' => 'nullable|email',
            'categorie' => 'nullable|string',
            'experience' => 'nullable|string',
            'statut_dispo' => 'required|string',
            'horaires_disponibles' => 'nullable',

        ]);

        $medecin->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $medecin->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'specialite' => $validated['specialite'],
            'telephone' => $validated['telephone'],
            'emailPro' => $validated['emailPro'] ?? null,
            'categorie' => $validated['categorie'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'statut_dispo' => $validated['statut_dispo'],
            'horaires_disponibles' => $request->horaires_disponibles
                ? json_decode($request->horaires_disponibles, true)
                : null,
        ]);

        return redirect()->route('medecin.index')
            ->with('success', 'Médecin mis à jour avec succès');
    }
}
