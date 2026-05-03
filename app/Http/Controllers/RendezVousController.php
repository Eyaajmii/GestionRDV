<?php

namespace App\Http\Controllers;

use App\Models\rendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // patient → ses RDV seulement
        if ($user->role === 'patient') {
            $rdvs = rendezVous::where('patient_id', $user->id)->get();
        }
        //médecin → ses RDV
        elseif ($user->role === 'doctor') {
            $rdvs = rendezVous::where('doctor_id', $user->medecin->id)->get();
        }
        //admin
        else {
            $rdvs = rendezVous::all();
        }

        return view('rendezvous.index', compact('rdvs'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date'       => 'required|date|after:today',
            'heure'      => 'required',
            'motif'      => 'required|string|min:5'
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
        $validated['patient_id'] = Auth::user()->patient->id;
        $validated['statut'] = 'planifié';

        RendezVous::create($validated);

        return redirect()->route('rendezvous.index')
            ->with('success', 'Votre rendez-vous est confirmé.');
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
            'time' => 'required',
            'motif' => 'required|string|min:5',
        ]);

        $rdv->update($request->only('date', 'time', 'motif'));

        return back()->with('success', 'Rendez-vous modifié');
    }

    public function destroy($id)
    {
        $rdv = rendezVous::findOrFail($id);
        if ($rdv->patient_id !== Auth::id()) {
            abort(403);
        }
        $rdv->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Rendez-vous annulé');
    }
}
