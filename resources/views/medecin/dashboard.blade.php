@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 py-8 px-6">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400 mb-0.5">Bonjour Docteur,</p>
                <h1 class="text-2xl font-semibold text-gray-900">
                    {{ Auth::user()->name }}
                </h1>
            </div>

            <div class="text-sm text-gray-400 bg-white border border-gray-200 rounded-lg px-3 py-2">
                {{ now()->translatedFormat('l d F Y') }}
            </div>
        </div>

        {{-- STATS --}}
        @php
        $stats_cards = [
        [
        'label' => 'Total RDV',
        'value' => $stats['total_rdv'],
        'trend' => '+5 ce mois',
        'trend_color' => 'text-violet-600',
        'icon_bg' => 'bg-violet-50',
        'icon_color' => 'text-violet-600',
        'icon' => '
        <rect x="1" y="1" width="6" height="6" rx="1.5" fill="currentColor" />
        <rect x="9" y="1" width="6" height="6" rx="1.5" fill="currentColor" />
        <rect x="1" y="9" width="6" height="6" rx="1.5" fill="currentColor" />
        <rect x="9" y="9" width="6" height="6" rx="1.5" fill="currentColor" />
        ',
        ],
        [
        'label' => 'RDV aujourd’hui',
        'value' => $stats['rdv_today'],
        'trend' => 'Planning du jour',
        'trend_color' => 'text-sky-600',
        'icon_bg' => 'bg-sky-50',
        'icon_color' => 'text-sky-600',
        'icon' => '
        <path d="M8 1v6l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.5" />
        ',
        ],
        [
        'label' => 'RDV à venir',
        'value' => $stats['prochains_rdv'],
        'trend' => 'Suivi patients',
        'trend_color' => 'text-emerald-600',
        'icon_bg' => 'bg-emerald-50',
        'icon_color' => 'text-emerald-600',
        'icon' => '
        <path d="M3 8l3 3 7-7" stroke="currentColor" stroke-width="1.8" />
        ',
        ],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($stats_cards as $s)
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="{{ $s['icon_bg'] }} w-10 h-10 rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 {{ $s['icon_color'] }}" viewBox="0 0 16 16" fill="none">
                        {!! $s['icon'] !!}
                    </svg>
                </div>

                <p class="text-sm text-gray-400">{{ $s['label'] }}</p>
                <p class="text-3xl font-semibold text-gray-900">{{ $s['value'] }}</p>
                <p class="text-xs mt-1 {{ $s['trend_color'] }}">{{ $s['trend'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- RDV DU JOUR --}}
        <div>
            <p class="text-sm font-medium text-gray-500 mb-3">Rendez-vous du jour</p>

            <div class="bg-white border border-gray-200 rounded-xl divide-y divide-gray-100">

                @forelse($rdvs_today as $r)
                <div class="flex items-center justify-between px-4 py-3">

                    <div>
                        {{-- NOM PATIENT --}}
                        <p class="text-sm font-medium text-gray-900">
                            {{ $r->patient->name ?? 'Patient' }}
                        </p>

                        {{-- MOTIF --}}
                        <p class="text-xs text-gray-400">
                            {{ $r->motif }}
                        </p>
                    </div>

                    <div class="text-right">
                        {{-- HEURE --}}
                        <p class="text-sm text-gray-500">
                            {{ $r->heure }}
                        </p>

                        {{-- STATUT --}}
                        <p class="text-xs
            {{ $r->statut == 'confirmé' ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $r->statut }}
                        </p>
                    </div>

                </div>
                @empty
                <div class="px-4 py-6 text-center text-sm text-gray-400">
                    Aucun rendez-vous aujourd’hui
                </div>
                @endforelse


            </div>
        </div>

    </div>
</div>

@endsection