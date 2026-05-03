<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;
use Illuminate\Support\Facades\Auth;

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

    public function show($id)
    {
        $medecin = Medecin::with(['user', 'rendezVous'])->findOrFail($id);

        $slots = [];

        foreach ($medecin->horaires_disponibles ?? [] as $horaire) {

            $start = strtotime($horaire['start']);
            $end = strtotime($horaire['end']);

            while ($start < $end) {
                $slots[] = date('H:i', $start);
                $start = strtotime('+30 minutes', $start);
            }
        }

        return view('medecin.show', compact('medecin', 'slots'));
    }

    public function edit()
    {
        $medecin = Auth::user()->medecin;

        if (!$medecin) {
            abort(404);
        }

        return view('medecins.edit', compact('medecin'));
    }

    public function update(Request $request)
    {
        $medecin = Auth::user()->medecin;

        if (!$medecin) {
            abort(404);
        }

        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'telephone' => 'required|string',
            'specialite' => 'required|string',
        ]);

        $medecin->update($validated);

        return back()->with('success', 'Profil mis à jour');
    }
}