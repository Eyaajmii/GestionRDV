<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisponibiliteController extends Controller
{
    public function edit()
    {
        $medecin = Auth::user()->medecin;

        return view('medecin.disponibilite', compact('medecin'));
    }

    public function update(Request $request)
    {
        $medecin = Auth::user()->medecin;

        $medecin->update([
            'horaires_disponibles' => $request->disponibilites,
            'first_login' => false
        ]);

        return redirect()->route('dashboard');
    }
}
