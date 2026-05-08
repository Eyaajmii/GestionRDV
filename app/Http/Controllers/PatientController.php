<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('patient.index', compact('patients'));
    }
    public function show($id)
    {
        $patient = Patient::with('user')->findOrFail($id);

        return response()->json($patient);
    }
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255|unique:users,email,' . $patient->user_id,
            'nom'             => 'required|string|max:255',
            'prenom'          => 'required|string|max:255',
            'telephone'       => 'nullable|string|max:20',
            'adresse'         => 'nullable|string|max:255',
            'date_naissance'  => 'nullable|date',
            'sexe'            => 'nullable|in:homme,femme',
        ]);
        $patient->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);
        $patient->update([
            'nom'             => $request->nom,
            'prenom'          => $request->prenom,
            'telephone'       => $request->telephone,
            'adresse'         => $request->adresse,
            'date_naissance'  => $request->date_naissance,
            'sexe'            => $request->sexe,
        ]);

        return redirect()
            ->route('patient.index')
            ->with('success', 'Patient modifié avec succès');
    }
    /*******PARTIE IA */
    public function resumeIA(Patient $patient)
    {
        if (Auth::user()->role !== 'medecin') {
            abort(403);
        }

        $rdvs = $patient->rendezVous()->with('medecin')->latest()->take(10)->get();

        if ($rdvs->isEmpty()) {
            return response()->json(['resume' => 'Aucun historique disponible pour ce patient.']);
        }

        $historique = $rdvs->map(function ($r) {
            $nom    = optional($r->medecin)->nom ?? '?';
            $prenom = optional($r->medecin)->prenom ?? '';
            return $r->date . ' : ' . $r->motif . ' (Dr. ' . $nom . ' ' . $prenom . ')';
        })->implode("\n");

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key='
            . config('services.gemini.key');

        try {
            $response = Http::post($url, [
                'contents' => [[
                    'parts' => [[
                        'text' => 'Tu es un assistant médical. Résume en 3 points clés cet historique de rendez-vous : ' . $historique
                    ]]
                ]]
            ]);

            if ($response->failed()) {
                return response()->json([
                    'resume' => "(Non IA) Historique du patient :\n\n" . $historique
                ]);
            }

            $resume = $response->json('candidates.0.content.parts.0.text') ?? 'Erreur lors de la génération.';
            return response()->json(['resume' => $resume]);
        } catch (\Exception $e) {
            return response()->json([
                'resume' => "(Non IA) Historique du patient :\n\n" . $historique
            ]);
        }
    }
}
