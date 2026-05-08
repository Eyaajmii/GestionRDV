@auth
@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')
@endauth

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">

    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-xl font-medium text-gray-900">Mes Rendez-vous</h1>
            <p class="text-sm text-blue-400 mt-1">Gestion et suivi de vos consultations</p>
        </div>
        @if(auth()->user()->role === 'patient')
        <a href="{{ route('rendezvous.create') }}"
            class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau RDV
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="mb-5 flex items-center gap-2 bg-green-50 text-green-800 border border-green-200 px-4 py-3 rounded-lg text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-5 flex items-center gap-2 bg-red-50 text-red-800 border border-red-200 px-4 py-3 rounded-lg text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <form method="GET"
        class="flex items-center gap-3 mb-5 bg-blue-50 border border-blue-200 rounded-lg px-4 py-3">
        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M7 8h10M11 12h2"/>
        </svg>
        <span class="text-xs font-medium text-blue-600 uppercase tracking-wide">Statut</span>
        <select name="statut"
            class="text-sm border border-blue-300 rounded-lg px-3 py-1.5 bg-white text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Tous les statuts</option>
            <option value="planifie"  {{ request('statut') == 'planifie'  ? 'selected' : '' }}>Planifié</option>
            <option value="confirme"  {{ request('statut') == 'confirme'  ? 'selected' : '' }}>Confirmé</option>
            <option value="annule"    {{ request('statut') == 'annule'    ? 'selected' : '' }}>Annulé</option>
            <option value="termine"   {{ request('statut') == 'termine'   ? 'selected' : '' }}>Terminé</option>
        </select>
        <button type="submit"
            class="text-sm font-medium text-blue-800 border border-blue-400 bg-white hover:bg-blue-100 px-4 py-1.5 rounded-lg transition-colors">
            Filtrer
        </button>
        @if(request('statut'))
        <a href="{{ url()->current() }}" class="text-xs text-red-400 hover:underline">Réinitialiser</a>
        @endif
        <span class="ml-auto text-xs text-blue-400">{{ $rdvs->count() }} résultats</span>
    </form>

    <div class="flex gap-5 items-start">

        <div class="flex-1 min-w-0">
            <div class="bg-white border border-blue-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 border-b border-blue-200">
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Médecin</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Statut</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-100" id="tbody-rdvs">
                        @forelse($rdvs as $rdv)
                        @php
                            $statut = $rdv->statut instanceof \App\Models\StatutRdv
                                ? $rdv->statut->value
                                : $rdv->statut;
                        @endphp

                        <tr data-rdv="{{ $rdv->id }}"
                            onclick="showRdv(this)"
                            class="hover:bg-blue-50/40 transition-colors cursor-pointer">

                            <td class="px-4 py-3">
                                <div class="font-medium text-blue-900">
                                    {{ \Carbon\Carbon::parse($rdv->date)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-blue-400 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke-width="1.5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2"/>
                                    </svg>
                                    {{ $rdv->heure }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">Dr. {{ $rdv->medecin->nom ?? 'N/A' }}</div>
                                @if($rdv->medecin->specialite ?? false)
                                <div class="text-xs text-blue-400 mt-0.5">{{ $rdv->medecin->specialite }}</div>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $rdv->patient->nom ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3">
                                @if($statut === 'confirme')
                                <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Confirmé
                                </span>
                                @elseif($statut === 'annule')
                                <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-800 border border-red-300 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Annulé
                                </span>
                                @elseif($statut === 'termine')
                                <span class="inline-flex items-center gap-1.5 bg-violet-100 text-violet-800 border border-violet-300 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span> Terminé
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 border border-blue-300 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Planifié
                                </span>
                                @endif
                            </td>

                            <td class="px-4 py-3" onclick="event.stopPropagation()">
                                <div class="flex flex-wrap gap-1.5 items-center">

                                    {{-- PATIENT --}}
                                    @if(auth()->user()->role === 'patient')
                                        @if($statut === 'planifie')
                                        <a href="{{ route('rendezvous.edit', $rdv->id) }}"
                                            class="inline-flex text-xs font-medium px-3 py-1.5 rounded-lg border border-amber-300 text-amber-900 bg-amber-100 hover:bg-amber-200 transition-colors">
                                            Modifier
                                        </a>
                                        @endif
                                        @if(!in_array($statut, ['annule', 'termine']))
                                        <form method="POST" action="{{ route('rendezvous.destroy', $rdv->id) }}">
                                            @csrf @method('DELETE')
                                            <button class="text-xs font-medium px-3 py-1.5 rounded-lg border border-red-300 text-red-800 bg-red-100 hover:bg-red-200 transition-colors">
                                                Annuler
                                            </button>
                                        </form>
                                        @endif
                                    @endif

                                    {{-- MÉDECIN --}}
                                    @if(auth()->user()->role === 'medecin')
                                        <button
                                            data-patient="{{ $rdv->patient_id }}"
                                            onclick="chargerResume(this.dataset.patient, this)"
                                            class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1.5 rounded-lg border border-blue-300 text-blue-800 bg-blue-100 hover:bg-blue-200 transition-colors">
                                            ✦ Résumé IA
                                        </button>
                                        @if($statut === 'planifie')
                                        <form method="POST" action="{{ route('rendezvous.confirmer', $rdv->id) }}">
                                            @csrf @method('PATCH')
                                            <button class="text-xs font-medium px-3 py-1.5 rounded-lg border border-emerald-300 text-emerald-800 bg-emerald-100 hover:bg-emerald-200 transition-colors">
                                                Confirmer
                                            </button>
                                        </form>
                                        @endif
                                        @if($statut === 'confirme')
                                        <form method="POST" action="{{ route('rendezvous.terminer', $rdv->id) }}">
                                            @csrf @method('PATCH')
                                            <button class="text-xs font-medium px-3 py-1.5 rounded-lg border border-violet-300 text-violet-900 bg-violet-100 hover:bg-violet-200 transition-colors">
                                                Terminer
                                            </button>
                                        </form>
                                        @endif
                                    @endif

                                    {{-- ADMIN --}}
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('rendezvous.edit', $rdv->id) }}"
                                            class="inline-flex text-xs font-medium px-3 py-1.5 rounded-lg border border-amber-300 text-amber-900 bg-amber-100 hover:bg-amber-200 transition-colors">
                                            Modifier
                                        </a>
                                        @if($statut === 'planifie')
                                        <form method="POST" action="{{ route('rendezvous.confirmer', $rdv->id) }}">
                                            @csrf @method('PATCH')
                                            <button class="text-xs font-medium px-3 py-1.5 rounded-lg border border-emerald-300 text-emerald-800 bg-emerald-100 hover:bg-emerald-200 transition-colors">
                                                Confirmer
                                            </button>
                                        </form>
                                        @endif
                                        @if($statut === 'confirme')
                                        <form method="POST" action="{{ route('rendezvous.terminer', $rdv->id) }}">
                                            @csrf @method('PATCH')
                                            <button class="text-xs font-medium px-3 py-1.5 rounded-lg border border-violet-300 text-violet-900 bg-violet-100 hover:bg-violet-200 transition-colors">
                                                Terminer
                                            </button>
                                        </form>
                                        @endif
                                        @if(!in_array($statut, ['annule', 'termine']))
                                        <form method="POST" action="{{ route('rendezvous.destroy', $rdv->id) }}">
                                            @csrf @method('DELETE')
                                            <button class="text-xs font-medium px-3 py-1.5 rounded-lg border border-red-300 text-red-800 bg-red-100 hover:bg-red-200 transition-colors">
                                                Annuler
                                            </button>
                                        </form>
                                        @endif
                                    @endif

                                </div>
                            </td>
                        </tr>

                        @if(auth()->user()->role === 'medecin')
                        <tr class="bg-blue-50/50">
                            <td colspan="5" class="px-4 pb-3 pt-0">
                                <div id="resume-{{ $rdv->patient_id }}"
                                    style="display:none"
                                    class="bg-blue-50 border-l-2 border-blue-400 rounded-r-lg px-4 py-3 text-sm text-blue-900 mt-2">
                                </div>
                            </td>
                        </tr>
                        @endif

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <svg class="w-10 h-10 text-blue-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.5"/>
                                    <path d="M16 2v4M8 2v4M3 10h18" stroke-width="1.5"/>
                                </svg>
                                <p class="text-sm text-blue-300">Aucun rendez-vous trouvé</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-72 flex-shrink-0">
            <div class="bg-white border border-blue-200 rounded-xl overflow-hidden sticky top-4">

                <div id="panel-empty" class="py-10 px-4 text-center">
                    <svg class="w-10 h-10 text-blue-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.5"/>
                        <path d="M16 2v4M8 2v4M3 10h18M12 14v4M10 16h4" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <p class="text-xs text-blue-300">Cliquez sur un rendez-vous<br>pour voir ses détails</p>
                </div>

                <div id="panel-content" class="hidden">

                    <div class="bg-blue-50 px-4 py-4 border-b border-blue-200 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 border border-blue-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.5"/>
                                <path d="M16 2v4M8 2v4M3 10h18" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <div id="p-date" class="text-sm font-medium text-blue-900"></div>
                            <div id="p-heure" class="text-xs text-blue-400 mt-0.5"></div>
                        </div>
                    </div>

                    <div class="p-4 space-y-3 text-xs max-h-[75vh] overflow-y-auto">

                        <div>
                            <p class="font-medium text-blue-500 uppercase tracking-wide mb-1">Statut</p>
                            <div id="p-statut"></div>
                        </div>

                        <hr class="border-blue-100">

                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-blue-500 uppercase tracking-wide">Médecin</p>
                                <p id="p-medecin" class="text-blue-900 mt-0.5"></p>
                                <p id="p-specialite" class="text-blue-400 mt-0.5"></p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-blue-500 uppercase tracking-wide">Patient</p>
                                <p id="p-patient" class="text-blue-900 mt-0.5"></p>
                                <p id="p-patient-tel" class="text-blue-400 mt-0.5"></p>
                            </div>
                        </div>

                        <hr class="border-blue-100">

                        <div>
                            <p class="font-medium text-blue-500 uppercase tracking-wide mb-1">Motif</p>
                            <p id="p-motif" class="text-blue-900 leading-relaxed"></p>
                        </div>

                        <div id="bloc-symptomes" class="hidden">
                            <p class="font-medium text-blue-500 uppercase tracking-wide mb-1">Symptômes</p>
                            <p id="p-symptomes" class="text-blue-900 leading-relaxed"></p>
                        </div>

                        <div id="bloc-douleur" class="hidden">
                            <p class="font-medium text-blue-500 uppercase tracking-wide mb-1">Niveau de douleur</p>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-blue-100 rounded-full h-1.5">
                                    <div id="p-douleur-bar" class="bg-blue-600 h-1.5 rounded-full transition-all"></div>
                                </div>
                                <span id="p-douleur" class="text-blue-900 font-medium w-8 text-right"></span>
                            </div>
                        </div>

                        <div id="bloc-allergies" class="hidden">
                            <p class="font-medium text-blue-500 uppercase tracking-wide mb-1">Allergies</p>
                            <p id="p-allergies" class="text-blue-900"></p>
                        </div>

                        <div id="bloc-medicaments" class="hidden">
                            <p class="font-medium text-blue-500 uppercase tracking-wide mb-1">Médicaments en cours</p>
                            <p id="p-medicaments" class="text-blue-900 leading-relaxed"></p>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@if(auth()->user()->role === 'medecin')
<script>
    function chargerResume(patientId, btn) {
        const zone = document.getElementById('resume-' + patientId);
        if (zone.style.display === 'block') {
            zone.style.display = 'none';
            btn.textContent = '✦ Résumé IA';
            return;
        }
        btn.textContent = 'Chargement…';
        btn.disabled = true;
        fetch(`/patients/${patientId}/resume-ia`)
            .then(r => r.json())
            .then(data => {
                zone.innerHTML = data.resume;
                zone.style.display = 'block';
                btn.textContent = 'Masquer';
                btn.disabled = false;
            })
            .catch(() => {
                zone.innerHTML = 'Erreur de connexion.';
                zone.style.display = 'block';
                btn.textContent = 'Réessayer';
                btn.disabled = false;
            });
    }
</script>
@endif

<script>
const statutBadges = {
    confirme: `<span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-medium px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Confirmé</span>`,
    annule:   `<span class="inline-flex items-center gap-1.5 bg-red-100 text-red-800 border border-red-300 text-xs font-medium px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Annulé</span>`,
    termine:  `<span class="inline-flex items-center gap-1.5 bg-violet-100 text-violet-800 border border-violet-300 text-xs font-medium px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span> Terminé</span>`,
    planifie: `<span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 border border-blue-300 text-xs font-medium px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Planifié</span>`,
};

function showRdv(row) {
    const id = row.dataset.rdv;
    document.querySelectorAll('#tbody-rdvs tr[data-rdv]').forEach(r => {
        r.classList.remove('bg-blue-100', 'border-l-2', 'border-blue-500');
    });
    row.classList.add('bg-blue-100', 'border-l-2', 'border-blue-500');

    fetch(`/rendezvous/${id}`)
        .then(r => r.json())
        .then(data => {
            const date = new Date(data.date);
            document.getElementById('p-date').textContent  = date.toLocaleDateString('fr-FR', { day: '2-digit', month: 'long', year: 'numeric' });
            document.getElementById('p-heure').textContent = data.heure ?? '';
            document.getElementById('p-statut').innerHTML = statutBadges[data.statut] ?? statutBadges['planifie'];
            document.getElementById('p-medecin').textContent    = data.medecin ? `Dr. ${data.medecin.nom} ${data.medecin.prenom}` : '-';
            document.getElementById('p-specialite').textContent = data.medecin?.specialite ?? '';
            document.getElementById('p-patient').textContent     = data.patient ? `${data.patient.nom} ${data.patient.prenom}` : '-';
            document.getElementById('p-patient-tel').textContent = data.patient?.telephone ?? '';
            document.getElementById('p-motif').textContent = data.motif ?? '-';
            toggleBloc('bloc-symptomes', 'p-symptomes', data.symptomes);
            if (data.niveau_douleur !== null && data.niveau_douleur !== undefined) {
                document.getElementById('bloc-douleur').classList.remove('hidden');
                document.getElementById('p-douleur').textContent        = data.niveau_douleur + '/10';
                document.getElementById('p-douleur-bar').style.width    = (data.niveau_douleur * 10) + '%';
            } else {
                document.getElementById('bloc-douleur').classList.add('hidden');
            }

            toggleBloc('bloc-allergies', 'p-allergies', data.allergies);
            toggleBloc('bloc-medicaments', 'p-medicaments', data.medicaments_en_cours);
            document.getElementById('panel-empty').classList.add('hidden');
            document.getElementById('panel-content').classList.remove('hidden');
        })
        .catch(err => console.error('Erreur fetch:', err));
}

function toggleBloc(blocId, fieldId, value) {
    const bloc = document.getElementById(blocId);
    if (value) {
        bloc.classList.remove('hidden');
        document.getElementById(fieldId).textContent = value;
    } else {
        bloc.classList.add('hidden');
    }
}
</script>

@endsection