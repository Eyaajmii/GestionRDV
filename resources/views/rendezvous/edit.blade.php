@auth
    @extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')
@endauth

@section('content')
<div class="max-w-lg mx-auto py-10 px-4">
    <div class="bg-white border border-blue-200 rounded-2xl p-8">

        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-blue-100">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.5"/>
                    <path d="M16 2v4M8 2v4M3 10h18" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-medium text-blue-900">Modifier le rendez-vous</h2>
                <p class="text-xs text-blue-400 mt-0.5">Mettez à jour les informations de votre consultation</p>
            </div>
        </div>

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            @foreach($errors->all() as $e) <p>{{ $e }}</p> @endforeach
        </div>
        @endif

        <form action="{{ route('rendezvous.update', $rdv->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Date --}}
            <div>
                <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Date</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.5"/>
                        <path d="M16 2v4M8 2v4M3 10h18" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <input type="date" name="date"
                        value="{{ old('date', \Carbon\Carbon::parse($rdv->date)->format('Y-m-d')) }}"
                        class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Heure</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="1.5"/>
                        <path d="M12 6v6l4 2" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <input type="time" name="heure"
                        value="{{ old('heure', $rdv->heure) }}"
                        class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Motif de la consultation</label>
                <div class="relative">
                    <svg class="absolute left-3 top-3 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h4M5 8h14M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                    </svg>
                    <textarea name="motif" rows="3"
                        placeholder="Décrivez le motif de votre consultation..."
                        class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition resize-none">{{ old('motif', $rdv->motif) }}</textarea>
                </div>
            </div>

            <div class="border border-blue-200 rounded-xl overflow-hidden">
                <div class="flex items-center gap-2.5 px-4 py-3 bg-blue-50 border-b border-blue-200">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h4M5 8h14M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                    </svg>
                    <span class="text-sm font-medium text-blue-800">
                        Informations médicales
                        <span class="text-blue-400 font-normal text-xs ml-1">(optionnel)</span>
                    </span>
                </div>

                <div class="p-4 space-y-4">

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Symptômes</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h4M5 8h14M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                            </svg>
                            <textarea name="symptomes" rows="2"
                                placeholder="Décrivez vos symptômes..."
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition resize-none">{{ old('symptomes', $rdv->symptomes) }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Niveau de douleur &nbsp;
                            <span id="douleur-value" class="text-blue-900 font-bold normal-case">
                                {{ old('niveau_douleur', $rdv->niveau_douleur ?? 0) }} / 10
                            </span>
                        </label>
                        <input type="range" name="niveau_douleur" id="range-douleur"
                            min="0" max="10"
                            value="{{ old('niveau_douleur', $rdv->niveau_douleur ?? 0) }}"
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                            <input type="text" name="allergies"
                                value="{{ old('allergies', $rdv->allergies) }}"
                                placeholder="ex: Pénicilline, pollen, arachides..."
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Médicaments en cours</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            <textarea name="medicaments_en_cours" rows="2"
                                placeholder="ex: Doliprane 1000mg, Metformine 500mg..."
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition resize-none">{{ old('medicaments_en_cours', $rdv->medicaments_en_cours) }}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-blue-100">
                <button type="submit"
                    class="flex-1 flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium py-2.5 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Mettre à jour
                </button>
                <a href="{{ route('rendezvous.index') }}"
                    class="flex items-center justify-center gap-2 px-5 py-2.5 border border-blue-300 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Annuler
                </a>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('range-douleur').addEventListener('input', function () {
        document.getElementById('douleur-value').textContent = this.value + ' / 10';
    });
</script>
@endsection