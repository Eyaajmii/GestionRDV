@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto py-10 px-4">
    <div class="bg-white border border-blue-200 rounded-2xl p-8">

        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-blue-100">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.5" />
                    <path d="M16 2v4M8 2v4M3 10h18M12 14v4M10 16h4" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-medium text-blue-900">Prendre un rendez-vous</h2>
                <p class="text-xs text-blue-400 mt-0.5">Suivez les étapes pour réserver votre consultation</p>
            </div>
        </div>

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('rendezvous.store') }}" class="space-y-1" id="form-rdv">
            @csrf

            <div class="pb-5 border-b border-blue-100">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-5 h-5 rounded-full bg-blue-100 border border-blue-300 text-blue-800 text-xs font-medium flex items-center justify-center flex-shrink-0">1</span>
                    <span class="text-xs font-medium text-blue-600 uppercase tracking-wide">Choisir une spécialité</span>
                </div>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <select id="select-specialite"
                        class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        <option value="">-- Sélectionner --</option>
                        @foreach($specialites as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="bloc-medecin" class="hidden pb-5 pt-4 border-b border-blue-100">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-5 h-5 rounded-full bg-blue-100 border border-blue-300 text-blue-800 text-xs font-medium flex items-center justify-center flex-shrink-0">2</span>
                    <span class="text-xs font-medium text-blue-600 uppercase tracking-wide">Choisir un médecin</span>
                </div>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <select id="select-medecin" name="medecin_id"
                        class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        <option value="">-- Sélectionner --</option>
                    </select>
                </div>
            </div>

            <div id="bloc-date" class="hidden pb-5 pt-4 border-b border-blue-100">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-5 h-5 rounded-full bg-blue-100 border border-blue-300 text-blue-800 text-xs font-medium flex items-center justify-center flex-shrink-0">3</span>
                    <span class="text-xs font-medium text-blue-600 uppercase tracking-wide">Choisir une date</span>
                </div>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.5" />
                        <path d="M16 2v4M8 2v4M3 10h18" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <input type="date" id="input-date" name="date"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                </div>
            </div>

            <div id="bloc-heures" class="hidden pb-5 pt-4 border-b border-blue-100">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-5 h-5 rounded-full bg-blue-100 border border-blue-300 text-blue-800 text-xs font-medium flex items-center justify-center flex-shrink-0">4</span>
                    <span class="text-xs font-medium text-blue-600 uppercase tracking-wide">Choisir un créneau</span>
                </div>
                <div id="grid-heures" class="grid grid-cols-4 gap-2"></div>
                <input type="hidden" name="heure" id="input-heure">
                <p id="msg-aucune" class="hidden text-xs text-blue-300 mt-2 italic">
                    Aucun créneau disponible pour ce jour.
                </p>
            </div>

            <div id="bloc-motif" class="hidden pb-5 pt-4 border-b border-blue-100">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-5 h-5 rounded-full bg-blue-100 border border-blue-300 text-blue-800 text-xs font-medium flex items-center justify-center flex-shrink-0">5</span>
                    <span class="text-xs font-medium text-blue-600 uppercase tracking-wide">Motif de la consultation</span>
                </div>
                <div class="relative">
                    <svg class="absolute left-3 top-3 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h4M5 8h14M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                    </svg>
                    <textarea name="motif" rows="3" placeholder="Décrivez le motif de votre consultation..."
                        class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition resize-none">{{ old('motif') }}</textarea>
                </div>
            </div>

            <div id="bloc-medical" class="hidden pt-4 pb-1 space-y-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-5 h-5 rounded-full bg-blue-100 border border-blue-300 text-blue-800 text-xs font-medium flex items-center justify-center flex-shrink-0">6</span>
                    <span class="text-xs font-medium text-blue-600 uppercase tracking-wide">
                        Informations médicales
                        <span class="text-blue-400 font-normal normal-case ml-1">(optionnel)</span>
                    </span>
                </div>

                <div>
                    <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Symptômes</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h4M5 8h14M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                        </svg>
                        <textarea name="symptomes" rows="2" placeholder="Décrivez vos symptômes..."
                            class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition resize-none">{{ old('symptomes') }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                        Niveau de douleur &nbsp;
                        <span id="douleur-value" class="text-blue-900 font-bold normal-case">0 / 10</span>
                    </label>
                    <input type="range" name="niveau_douleur" id="range-douleur"
                        min="0" max="10" value="{{ old('niveau_douleur', 0) }}"
                        class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                    <div class="flex justify-between text-xs text-blue-400 mt-1">
                        <span>0 — Aucune</span>
                        <span>5 — Modérée</span>
                        <span>10 — Insupportable</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Allergies connues</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                        <input type="text" name="allergies" value="{{ old('allergies') }}"
                            placeholder="ex: Pénicilline, pollen, arachides..."
                            class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Médicaments en cours</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        <textarea name="medicaments_en_cours" rows="2"
                            placeholder="ex: Doliprane 1000mg, Metformine 500mg..."
                            class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition resize-none">{{ old('medicaments_en_cours') }}</textarea>
                    </div>
                </div>

            </div>

            <button id="btn-submit" type="submit"
                class="hidden w-full flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium py-2.5 rounded-lg transition-colors mt-5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Valider le rendez-vous
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('select-specialite').addEventListener('change', function() {
        const specialite = this.value;
        ['bloc-medecin', 'bloc-date', 'bloc-heures', 'bloc-motif', 'bloc-medical', 'btn-submit']
        .forEach(id => document.getElementById(id).classList.add('hidden'));
        if (!specialite) return;
        fetch(`/api/medecins-by-specialite?specialite=${encodeURIComponent(specialite)}`)
            .then(r => r.json())
            .then(medecins => {
                const sel = document.getElementById('select-medecin');
                sel.innerHTML = '<option value="">-- Sélectionner --</option>';
                medecins.forEach(m => {
                    sel.innerHTML += `<option value="${m.id}">Dr. ${m.nom} ${m.prenom}</option>`;
                });
                document.getElementById('bloc-medecin').classList.remove('hidden');
            });
    });

    document.getElementById('select-medecin').addEventListener('change', function() {
        ['bloc-date', 'bloc-heures', 'bloc-motif', 'bloc-medical', 'btn-submit']
        .forEach(id => document.getElementById(id).classList.add('hidden'));
        document.getElementById('input-date').value = '';
        if (!this.value) return;
        document.getElementById('bloc-date').classList.remove('hidden');
    });

    document.getElementById('input-date').addEventListener('change', function() {
        const date = this.value;
        const medecinId = document.getElementById('select-medecin').value;
        ['bloc-heures', 'bloc-motif', 'bloc-medical', 'btn-submit']
        .forEach(id => document.getElementById(id).classList.add('hidden'));
        document.getElementById('input-heure').value = '';
        if (!date || !medecinId) return;

        fetch(`/api/heures-disponibles?medecin_id=${medecinId}&date=${date}`)
            .then(r => r.json())
            .then(heures => {
                const grid = document.getElementById('grid-heures');
                const msg = document.getElementById('msg-aucune');
                grid.innerHTML = '';
                msg.classList.add('hidden');

                if (heures.length === 0) {
                    msg.classList.remove('hidden');
                } else {
                    heures.forEach(h => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.textContent = h.heure;
                        if (h.disabled) {
                            btn.disabled = true;
                            btn.className = 'py-2 px-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-400 line-through cursor-not-allowed border border-slate-200';
                            btn.title = 'Créneau déjà réservé';
                        } else {
                            btn.className = 'py-2 px-1 rounded-lg text-xs font-medium border border-blue-300 bg-blue-50 text-blue-800 hover:bg-blue-100 transition cursor-pointer';
                            btn.addEventListener('click', function() {
                                grid.querySelectorAll('button:not(:disabled)').forEach(b => {
                                    b.className = 'py-2 px-1 rounded-lg text-xs font-medium border border-blue-300 bg-blue-50 text-blue-800 hover:bg-blue-100 transition cursor-pointer';
                                });
                                this.className = 'py-2 px-1 rounded-lg text-xs font-medium bg-blue-700 text-white border border-blue-700';
                                document.getElementById('input-heure').value = h.heure;
                                document.getElementById('bloc-motif').classList.remove('hidden');
                                document.getElementById('bloc-medical').classList.remove('hidden');
                                document.getElementById('btn-submit').classList.remove('hidden');
                            });
                        }
                        grid.appendChild(btn);
                    });
                }
                document.getElementById('bloc-heures').classList.remove('hidden');
            });
    });
    document.getElementById('range-douleur').addEventListener('input', function() {
        document.getElementById('douleur-value').textContent = this.value + ' / 10';
    });
</script>
@endsection