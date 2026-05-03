<?php
use App\Http\Controllers\RendezVousController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('rendezvous', RendezVousController::class);
});