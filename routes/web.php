<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\AdminController;

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
    Route::resource('rendezvous', RendezVousController::class);

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::get('/admin/medecins', [AdminController::class, 'gestionMedecins'])
            ->name('admin.medecins');

        Route::get('/admin/rendezvous', [AdminController::class, 'gestionRendezVous'])
            ->name('admin.rendezvous');
    });

    /*
    |--------------------------------------------------------------------------
    | MEDECIN ONLY (optionnel si tu veux CRUD medecin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:medecin'])->group(function () {
        Route::resource('medecins', MedecinController::class);
    });
});
