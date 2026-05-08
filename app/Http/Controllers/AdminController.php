<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Patient;
use App\Http\Controllers\MedecinController;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'medecins' => Medecin::count(),
            'patients' => Patient::count(),
            'rdvs' => RendezVous::count(),
            'rdv_today' => RendezVous::whereDate('date', today())->count(),
            'rdv_confirmes' => RendezVous::where('statut', 'confirmé')->count(),
            'rdv_annules' => RendezVous::where('statut', 'annulé')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function gestionMedecins(Request $request)
    {
        $query = Medecin::with('user');
        if ($request->filled('specialite')) {
            $query->where('specialite', $request->specialite);
        }

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        $medecins = $query->latest()->get();

        return view('medecin.index', compact('medecins'));
    }

    public function gestionRendezVous(Request $request)
    {
        $query = RendezVous::with(['medecin', 'patient']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        if ($request->filled('medecin_id')) {
            $query->where('medecin_id', $request->medecin_id);
        }
        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%');
            });
        }

        $rdvs = $query->latest()->paginate(10);

        $medecins = Medecin::all();

        return view('rendezvous.index', compact('rdvs', 'medecins'));
    }
}