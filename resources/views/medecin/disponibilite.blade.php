@extends('layouts.app')

@section('content')

@php
$jours = [
    'lundi' => 'Lundi',
    'mardi' => 'Mardi',
    'mercredi' => 'Mercredi',
    'jeudi' => 'Jeudi',
    'vendredi' => 'Vendredi',
    'samedi' => 'Samedi',
    'dimanche' => 'Dimanche',
];
@endphp

<div class="min-h-screen bg-gray-50 py-10">

    <div class="max-w-7xl mx-auto px-6">

        {{-- HEADER --}}
        <div class="mb-10">

            <h1 class="text-3xl font-bold text-gray-800">
                Mes disponibilités
            </h1>

            <p class="text-gray-500 mt-2">
                Définissez vos horaires de consultation et vos pauses.
            </p>

        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-8">

                <form method="POST"
                      action="{{ route('medecin.disponibilite.update') }}">

                    @csrf

                    <div class="space-y-6">

                        @foreach($jours as $key => $jour)

                        <div class="border border-gray-200 rounded-2xl p-6 hover:border-indigo-300 transition duration-200">

                            {{-- TOP --}}
                            <div class="flex items-center justify-between mb-6">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">

                                        <svg class="w-6 h-6 text-indigo-600"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.8"
                                                  d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />

                                        </svg>

                                    </div>

                                    <div>

                                        <h2 class="text-lg font-semibold text-gray-800">
                                            {{ $jour }}
                                        </h2>

                                        <p class="text-sm text-gray-400">
                                            Horaires et pauses
                                        </p>

                                    </div>

                                </div>

                                {{-- STATUT --}}
                                <div>

                                    <select
                                        name="disponibilites[{{ $key }}][actif]"
                                        class="rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                                        <option value="1"
                                            {{ ($medecin->horaires_disponibles[$key]['actif'] ?? '') == 1 ? 'selected' : '' }}>
                                            Disponible
                                        </option>

                                        <option value="0"
                                            {{ ($medecin->horaires_disponibles[$key]['actif'] ?? '') == 0 ? 'selected' : '' }}>
                                            Indisponible
                                        </option>

                                    </select>

                                </div>

                            </div>

                            {{-- HORAIRES --}}
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                                {{-- DEBUT --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-600 mb-2">
                                        Début
                                    </label>

                                    <input type="time"
                                           name="disponibilites[{{ $key }}][debut]"
                                           value="{{ $medecin->horaires_disponibles[$key]['debut'] ?? '' }}"
                                           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                                </div>

                                {{-- PAUSE DEBUT --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-600 mb-2">
                                        Pause début
                                    </label>

                                    <input type="time"
                                           name="disponibilites[{{ $key }}][pause_debut]"
                                           value="{{ $medecin->horaires_disponibles[$key]['pause_debut'] ?? '' }}"
                                           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                                </div>

                                {{-- PAUSE FIN --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-600 mb-2">
                                        Pause fin
                                    </label>

                                    <input type="time"
                                           name="disponibilites[{{ $key }}][pause_fin]"
                                           value="{{ $medecin->horaires_disponibles[$key]['pause_fin'] ?? '' }}"
                                           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                                </div>

                                {{-- FIN --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-600 mb-2">
                                        Fin
                                    </label>

                                    <input type="time"
                                           name="disponibilites[{{ $key }}][fin]"
                                           value="{{ $medecin->horaires_disponibles[$key]['fin'] ?? '' }}"
                                           class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                    {{-- BUTTON --}}
                    <div class="mt-10 flex justify-end">

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-medium transition shadow-lg shadow-indigo-100">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>

                            </svg>

                            Enregistrer les disponibilités

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection