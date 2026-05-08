@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-gray-50 py-8 px-6">

    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-gray-400">Bienvenue Admin</p>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Tableau de bord
                </h1>
            </div>

            <div class="text-sm text-gray-500 bg-white border rounded-lg px-3 py-2">
                {{ now()->translatedFormat('l d F Y') }}
            </div>

        </div>
        @php
        $cards = [
        [
        'label' => 'Médecins',
        'value' => $stats['medecins'],
        'color' => 'text-indigo-600',
        'bg' => 'bg-indigo-50',
        'icon' => '
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM4 20a8 8 0 0116 0" />
        '
        ],
        [
        'label' => 'Patients',
        'value' => $stats['patients'],
        'color' => 'text-emerald-600',
        'bg' => 'bg-emerald-50',
        'icon' => '
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m10-4.13A4 4 0 1113 4a4 4 0 014 6zM7 8a4 4 0 100-8 4 4 0 000 8z" />
        '
        ],
        [
        'label' => 'Rendez-vous',
        'value' => $stats['rdv'],
        'color' => 'text-sky-600',
        'bg' => 'bg-sky-50',
        'icon' => '
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        '
        ],
        [
        'label' => 'Aujourd’hui',
        'value' => $stats['rdv_today'],
        'color' => 'text-rose-600',
        'bg' => 'bg-rose-50',
        'icon' => '
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        '
        ],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            @foreach($cards as $c)
            <div class="bg-white border rounded-xl p-5 shadow-sm hover:shadow-md transition">

                <div class="{{ $c['bg'] }} w-11 h-11 rounded-lg flex items-center justify-center mb-3">

                    <svg class="w-6 h-6 {{ $c['color'] }}"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8">

                        {!! $c['icon'] !!}

                    </svg>

                </div>

                <p class="text-sm text-gray-400">{{ $c['label'] }}</p>
                <p class="text-3xl font-semibold text-gray-900">{{ $c['value'] }}</p>

                <p class="text-xs text-gray-400 mt-1">
                    Statistiques globales
                </p>

            </div>
            @endforeach

        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <a href="{{ route('patients.index') }}"
                class="bg-white border rounded-xl p-5 hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800">Gérer les patients</h3>
                <p class="text-sm text-gray-400 mt-1">Voir / modifier les patients</p>
            </a>

            <a href="{{ route('medecin.index') }}"
                class="bg-white border rounded-xl p-5 hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800">Médecins</h3>
                <p class="text-sm text-gray-400 mt-1">Gestion des médecins</p>
            </a>

            <a href="{{ route('rendezvous.index') }}"
                class="bg-white border rounded-xl p-5 hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800">Rendez-vous</h3>
                <p class="text-sm text-gray-400 mt-1">Voir tous les RDV</p>
            </a>

        </div>

    </div>

</div>

@endsection