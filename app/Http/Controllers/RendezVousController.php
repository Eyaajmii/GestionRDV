<?php

namespace App\Http\Controllers;

use App\Models\rendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StatutRdv;
use App\Models\Medecin;

class RendezVousController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = RendezVous::with(['medecin', 'patient']);
        if ($user->role === 'patient') {
            $query->where('patient_id', $user->patient->id ?? $user->id);
        } elseif ($user->role === 'medecin') {
            $query->where('medecin_id', $user->medecin->id ?? null);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $rdvs = $query->latest()->get();

        return view('rendezvous.index', compact('rdvs'));
    }
    public function show($id)
    {
        $rdv = RendezVous::with(['patient.user', 'medecin.user'])
            ->findOrFail($id);
        return response()->json($rdv);
    }
    public function create()
    {
        $specialites = Medecin::select('specialite')
            ->distinct()
            ->pluck('specialite');

        return view('rendezvous.create', compact('specialites'));
    }

    public function medecinsBySpecialite(Request $request)
    {
        $medecins = Medecin::where('specialite', $request->specialite)
            ->get(['id', 'nom', 'prenom']);

        return response()->json($medecins);
    }

    public function heuresDisponibles(Request $request)
    {
        $medecin = Medecin::findOrFail($request->medecin_id);

        $date = $request->date;
        $jour = strtolower(\Carbon\Carbon::parse($date)->locale('fr')->dayName);

        $config = $medecin->horaires_disponibles[$jour] ?? null;

        if (!$config || $config['actif'] == "0") {
            return response()->json([]);
        }

        $debut = $config['debut'];
        $fin = $config['fin'];
        $pause_debut = $config['pause_debut'];
        $pause_fin = $config['pause_fin'];

        $step = 30; // minutes

        $heures = [];

        $start = strtotime($debut);
        $end = strtotime($fin);

        while ($start < $end) {

            $heure = date('H:i', $start);

            // skip pause
            $inPause = $pause_debut && $pause_fin &&
                $heure >= $pause_debut && $heure < $pause_fin;

            if (!$inPause) {
                $heures[] = $heure;
            }

            $start += $step * 60;
        }

        $heuresReservees = RendezVous::where('medecin_id', $request->medecin_id)
            ->where('date', $date)
            ->whereNotIn('statut', ['annule'])
            ->pluck('heure')
            ->map(fn($h) => substr($h, 0, 5))
            ->toArray();

        return response()->json(
            collect($heures)->map(fn($h) => [
                'heure' => $h,
                'disabled' => in_array($h, $heuresReservees),
            ])
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date'       => 'required|date|after_or_equal:today',
            'heure'      => 'required',
            'motif'      => 'required|string|min:5',
            'symptomes'           => 'nullable|string',
            'niveau_douleur'      => 'nullable|integer|min:0|max:10',
            'allergies'           => 'nullable|string|max:255',
            'medicaments_en_cours' => 'nullable|string',
        ]);

        $exists = RendezVous::where('medecin_id', $request->medecin_id)
            ->where('date', $request->date)
            ->where('heure', $request->heure)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['creneau' => 'Ce créneau est déjà réservé.']);
        }

        $validated['patient_id'] = Auth::id();
        $validated['statut']     = StatutRdv::Planifie;

        RendezVous::create($validated);

        return redirect()->route('rendezvous.index')
            ->with('success', 'Votre rendez-vous a bien été planifié.');
    }
    public function edit($id)
    {
        $rdv = rendezVous::findOrFail($id);

        return view('rendezvous.edit', compact('rdv'));
    }
    public function update(Request $request, $id)
    {
        $rdv = rendezVous::findOrFail($id);
        if ($rdv->patient_id !== Auth::id()) {
            abort(403);
        }

        if ($rdv->date < now()->toDateString()) {
            return back()->with('error', 'Impossible de modifier un RDV passé');
        }

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required',
            'motif' => 'required|string|min:5',
        ]);

        $rdv->update($request->only('date', 'heure', 'motif'));

        return redirect()->route('rendezvous.index')
            ->with('success', 'Votre rendez-vous bien modifié.');
    }

    public function destroy($id) //Annuler par patient ou admin
    {
        $rdv = RendezVous::findOrFail($id);

        if (Auth::user()->role === 'patient' && $rdv->patient_id !== Auth::id()) {
            abort(403);
        }

        $rdv->update(['statut' => StatutRdv::Annule]);

        return back()->with('success', 'Rendez-vous annulé.');
    }
    public function confirmer($id) //confirmer par med ou admin
    {
        $rdv = RendezVous::findOrFail($id);

        if (!in_array(Auth::user()->role, ['medecin', 'admin'])) {
            abort(403);
        }

        $rdv->update(['statut' => StatutRdv::Confirme]);

        return back()->with('success', 'Rendez-vous confirmé.');
    }
    public function terminer($id) //terminer par med ou admin
    {
        $rdv = RendezVous::findOrFail($id);

        if (!in_array(Auth::user()->role, ['medecin', 'admin'])) {
            abort(403);
        }

        $rdv->update(['statut' => StatutRdv::Termine]);

        return back()->with('success', 'Rendez-vous marqué comme terminé.');
    }
}
