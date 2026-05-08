<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DisponibiliteController;
use App\Http\Controllers\PatientController;


Route::get('/', function () {
    return view('welcome');
});
require __DIR__ . '/auth.php';
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::resource('patients', PatientController::class);
    Route::get('/rendezvous/export-pdf', [RendezVousController::class, 'exportPdf'])
        ->name('rendezvous.export.pdf');

    Route::resource('rendezvous', RendezVousController::class);
    Route::patch('rendezvous/{id}/confirmer', [RendezVousController::class, 'confirmer'])
        ->name('rendezvous.confirmer');
    Route::patch('rendezvous/{id}/terminer', [RendezVousController::class, 'terminer'])
        ->name('rendezvous.terminer');
    Route::resource('medecin', MedecinController::class);
    Route::get('/medecin-params/disponibilite', [DisponibiliteController::class, 'edit'])
        ->name('medecin.disponibilite');
    Route::post('/medecin-params/disponibilite', [DisponibiliteController::class, 'update'])
        ->name('medecin.disponibilite.update');
    Route::get('/api/medecins-by-specialite', [RendezVousController::class, 'medecinsBySpecialite'])
        ->name('api.medecins');

    Route::get('/api/heures-disponibles', [RendezVousController::class, 'heuresDisponibles'])
        ->name('api.heures');
    Route::get('/patients/{patient}/resume-ia', [PatientController::class, 'resumeIA'])
        ->name('patient.resume');
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::get('/admin/medecins', [AdminController::class, 'gestionMedecins'])
            ->name('admin.medecins');

        Route::get('/admin/rendezvous', [AdminController::class, 'gestionRendezVous'])
            ->name('admin.rendezvous');
    });
    Route::middleware(['role:medecin'])->group(function () {
        Route::resource('medecins', MedecinController::class);
    });
});
