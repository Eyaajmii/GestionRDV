<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\RendezVous;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // MEDECIN
        if ($user->medecin) {

            $medecin = $user->medecin;
        
            $rdvs_today = $medecin->rendezVous()
                ->whereDate('date', today())
                ->orderBy('heure', 'asc')
                ->get();
        
            $stats = [
                'total_rdv' => $medecin->rendezVous()->count(),
                'rdv_today' => $rdvs_today->count(),
                'prochains_rdv' => $medecin->rendezVous()
                    ->where('date', '>=', today())
                    ->count(),
            ];
        
            return view('medecin.dashboard', compact('stats', 'medecin', 'rdvs_today'));
        }

        //PATIENT
        if ($user->patient) {

            $patient = $user->patient;

            $stats = [
                'total_rdv' => $patient->rendezVous()->count(),
                'prochains_rdv' => $patient->rendezVous()
                    ->where('date', '>=', today())
                    ->count(),
            ];

            return view('patient.dashboard', compact('stats', 'patient'));
        }

        //ADMIN
        if ($user->role === 'admin') {

            $stats = [
                'medecins' => Medecin::count(),
                'patients' => Patient::count(),
                'rdv' => RendezVous::count(),
                'rdv_today' => RendezVous::whereDate('date', today())->count(),
            ];

            return view('admin.dashboard', compact('stats'));
        }

        abort(403);
    }
}