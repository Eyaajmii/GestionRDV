@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 py-8 px-6">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400 mb-0.5">Bonjour,</p>
                <h1 class="text-2xl font-semibold text-gray-900">{{ Auth::user()->name }}</h1>
            </div>
            <div class="text-sm text-gray-400 bg-white border border-gray-200 rounded-lg px-3 py-2">
                {{ now()->translatedFormat('l d F Y') }}
            </div>
        </div>

        {{-- STATS --}}
        @php
        $stats_cards = [
            [
                'label' => 'Total rendez-vous',
                'value' => $stats['total_rdv'],
                'trend' => '+2 ce mois',
                'trend_color' => 'text-emerald-600',
                'icon_bg' => 'bg-blue-50',
                'icon_color' => 'text-blue-500',
                'icon' => '
                    <rect x="1" y="1" width="6" height="6" rx="1.5" fill="currentColor"/>
                    <rect x="9" y="1" width="6" height="6" rx="1.5" fill="currentColor"/>
                    <rect x="1" y="9" width="6" height="6" rx="1.5" fill="currentColor"/>
                    <rect x="9" y="9" width="6" height="6" rx="1.5" fill="currentColor"/>
                ',
            ],
            [
                'label' => 'À venir',
                'value' => $stats['prochains_rdv'],
                'trend' => $stats['prochains_rdv'] > 0 ? 'Prochain : 12 mai' : 'Aucun RDV à venir',
                'trend_color' => $stats['prochains_rdv'] > 0 ? 'text-gray-400' : 'text-gray-300',
                'icon_bg' => 'bg-green-50',
                'icon_color' => 'text-green-700',
                'icon' => '
                    <path d="M8 1v6l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.5"/>
                ',
            ],
            [
                'label' => 'Effectués',
                'value' => $stats['rdv_effectues'] ?? 8,
                'trend' => 'Depuis jan. 2026',
                'trend_color' => 'text-gray-400',
                'icon_bg' => 'bg-teal-50',
                'icon_color' => 'text-teal-700',
                'icon' => '
                    <path d="M3 8l3 3 7-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                ',
            ],
            [
                'label' => 'Annulés',
                'value' => $stats['rdv_annules'] ?? 1,
                'trend' => '1 en attente',
                'trend_color' => 'text-amber-600',
                'icon_bg' => 'bg-amber-50',
                'icon_color' => 'text-amber-700',
                'icon' => '
                    <path d="M8 2v4l2 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.5"/>
                ',
            ],
        ];
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($stats_cards as $s)
            <div class="bg-gray-100 rounded-xl p-4">
                <div class="{{ $s['icon_bg'] }} w-8 h-8 rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-4 h-4 {{ $s['icon_color'] }}" viewBox="0 0 16 16" fill="none">
                        {!! $s['icon'] !!}
                    </svg>
                </div>
                <p class="text-xs text-gray-400 mb-1">{{ $s['label'] }}</p>
                <p class="text-2xl font-semibold text-gray-900 leading-none">{{ $s['value'] }}</p>
                <p class="text-[11px] {{ $s['trend_color'] }} mt-1.5">{{ $s['trend'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- PROCHAINS RDV --}}
        <div>
            <p class="text-[13px] font-medium text-gray-500 mb-3">Prochains rendez-vous</p>
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100">
                @php
                $prochains = [
                    ['jour' => '12', 'mois' => 'Mai', 'doc' => 'Dr. Sonia Mrad', 'spec' => 'Cardiologie · Clinique El Manar', 'heure' => '09:30', 'statut' => 'Confirmé', 'st_class' => 'bg-emerald-50 text-emerald-700', 'box_bg' => 'bg-blue-50', 'box_text' => 'text-blue-600'],
                    ['jour' => '20', 'mois' => 'Mai', 'doc' => 'Dr. Anis Touati', 'spec' => 'Médecine générale · Cabinet privé', 'heure' => '14:00', 'statut' => 'En attente', 'st_class' => 'bg-amber-50 text-amber-700', 'box_bg' => 'bg-amber-50', 'box_text' => 'text-amber-600'],
                    ['jour' => '03', 'mois' => 'Juin', 'doc' => 'Dr. Leila Gharbi', 'spec' => 'Dermatologie · Polyclinique Tunis', 'heure' => '11:15', 'statut' => 'Planifié', 'st_class' => 'bg-gray-100 text-gray-500', 'box_bg' => 'bg-gray-100', 'box_text' => 'text-gray-500'],
                ];
                @endphp

                @forelse($prochains as $rdv)
                <div class="flex items-center gap-4 px-4 py-3.5">
                    <div class="{{ $rdv['box_bg'] }} w-10 h-10 rounded-lg flex flex-col items-center justify-center shrink-0">
                        <span class="text-base font-semibold {{ $rdv['box_text'] }} leading-none">{{ $rdv['jour'] }}</span>
                        <span class="text-[9px] {{ $rdv['box_text'] }} uppercase tracking-widest">{{ $rdv['mois'] }}</span>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-medium text-gray-900">{{ $rdv['doc'] }}</p>
                        <p class="text-[12px] text-gray-400 mt-0.5 truncate">{{ $rdv['spec'] }}</p>
                    </div>

                    <span class="text-[12px] text-gray-500 shrink-0">{{ $rdv['heure'] }}</span>
                    <span class="text-[11px] px-2.5 py-1 rounded-full {{ $rdv['st_class'] }} shrink-0">
                        {{ $rdv['statut'] }}
                    </span>
                </div>
                @empty
                <div class="px-4 py-6 text-center text-sm text-gray-400">
                    Aucun rendez-vous à venir.
                </div>
                @endforelse
            </div>
        </div>

        {{-- HISTORIQUE + NOTIFICATIONS --}}
        <div class="grid md:grid-cols-2 gap-4">

            {{-- HISTORIQUE --}}
            <div>
                <p class="text-[13px] font-medium text-gray-500 mb-3">Historique récent</p>
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100">

                    @php
                    $historique = [
                        ['doc' => 'Dr. Sonia Mrad — Cardiologie', 'date' => '28 avril 2026 · 09:00', 'statut' => 'Effectué', 'dot' => 'bg-emerald-500', 'st_class' => 'bg-emerald-50 text-emerald-700'],
                        ['doc' => 'Dr. Anis Touati — Généraliste', 'date' => '10 avril 2026 · 14:30', 'statut' => 'Effectué', 'dot' => 'bg-emerald-500', 'st_class' => 'bg-emerald-50 text-emerald-700'],
                        ['doc' => 'Dr. Rami Selmi — Ophtalmologie', 'date' => '2 mars 2026 · 10:00', 'statut' => 'Annulé', 'dot' => 'bg-amber-400', 'st_class' => 'bg-amber-50 text-amber-700'],
                    ];
                    @endphp

                    @foreach($historique as $h)
                    <div class="flex items-center gap-3 px-4 py-3">
                        <div class="{{ $h['dot'] }} w-2 h-2 rounded-full shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] text-gray-800">{{ $h['doc'] }}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $h['date'] }}</p>
                        </div>
                        <span class="text-[11px] px-2.5 py-1 rounded-full {{ $h['st_class'] }}">
                            {{ $h['statut'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- NOTIFICATIONS --}}
            <div>
                <p class="text-[13px] font-medium text-gray-500 mb-3">Notifications</p>
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100">

                    @php
                    $notifs = [
                        [
                            'icon_bg' => 'bg-blue-50',
                            'icon_color' => 'text-blue-600',
                            'text' => 'Rappel : RDV avec Dr. Mrad demain à 09:30',
                            'time' => 'Il y a 2 heures',
                            'icon' => '<path d="M7 1a4 4 0 014 4v2l1 2H2L3 7V5a4 4 0 014-4zM5.5 11a1.5 1.5 0 003 0" stroke="currentColor" stroke-width="1.3"/>',
                        ],
                        [
                            'icon_bg' => 'bg-emerald-50',
                            'icon_color' => 'text-emerald-600',
                            'text' => 'Votre RDV du 28 avr. a été confirmé',
                            'time' => '28 avril 2026',
                            'icon' => '<path d="M2 7l3 3 7-7" stroke="currentColor" stroke-width="1.5"/>',
                        ],
                        [
                            'icon_bg' => 'bg-amber-50',
                            'icon_color' => 'text-amber-600',
                            'text' => 'RDV annulé par le médecin',
                            'time' => '2 mars 2026',
                            'icon' => '<circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="1.3"/>',
                        ],
                    ];
                    @endphp

                    @foreach($notifs as $n)
                    <div class="flex gap-3 px-4 py-3 items-start">
                        <div class="{{ $n['icon_bg'] }} w-7 h-7 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 {{ $n['icon_color'] }}" viewBox="0 0 14 14" fill="none">
                                {!! $n['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-600">{{ $n['text'] }}</p>
                            <p class="text-[11px] text-gray-400">{{ $n['time'] }}</p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

        </div>

    </div>
</div>

@endsection