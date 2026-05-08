@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex justify-between items-start mb-7">
        <div>
            <h1 class="text-xl font-medium text-blue-900">Liste des médecins</h1>
            <p class="text-sm text-blue-400 mt-1">Gestion du corps médical</p>
        </div>
        <a href="{{ route('medecin.create') }}"
            class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter médecin
        </a>
    </div>

    <div class="flex gap-5 items-start">

        <div class="flex-1 min-w-0">
            <div class="bg-white border border-blue-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 border-b border-blue-200">
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Nom</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Prénom</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Spécialité</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Téléphone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Email</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-blue-700 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-100" id="tbody-medecins">
                        @forelse($medecins as $medecin)
                        <tr data-medecin="{{ $medecin->id }}"
                            onclick="showMedecin(this)"
                            class="hover:bg-blue-50/50 transition-colors cursor-pointer">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-xs font-medium text-blue-800 flex-shrink-0">
                                        {{ strtoupper(substr($medecin->nom,0,1).substr($medecin->prenom,0,1)) }}
                                    </div>
                                    <span class="font-medium text-blue-900">{{ $medecin->nom }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $medecin->prenom }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-300">
                                    {{ $medecin->specialite }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-blue-500 text-xs">{{ $medecin->telephone }}</td>
                            <td class="px-4 py-3 text-blue-500 text-xs">{{ $medecin->user->email ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('medecin.edit', $medecin->id) }}"
                                    class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1.5 rounded-lg border border-amber-300 text-amber-900 bg-amber-100 hover:bg-amber-200 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Modifier
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-10">
                                <svg class="w-10 h-10 text-blue-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <p class="text-sm text-blue-300">Aucun médecin trouvé</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-64 flex-shrink-0">
            <div class="bg-white border border-blue-200 rounded-xl overflow-hidden">

                <div id="panel-empty" class="py-10 px-4 text-center">
                    <svg class="w-10 h-10 text-blue-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <p class="text-xs text-blue-300 leading-relaxed">Cliquez sur un médecin<br>pour voir ses détails</p>
                </div>

                <div id="panel-content" class="hidden">
                    <div class="bg-blue-50 px-4 py-4 border-b border-blue-200 flex items-center gap-3">
                        <div id="m-avatar"
                            class="w-10 h-10 rounded-full bg-blue-200 border border-blue-300 flex items-center justify-center text-sm font-medium text-blue-800 flex-shrink-0">
                        </div>
                        <div>
                            <div id="m-name" class="text-sm font-medium text-blue-900"></div>
                            <div id="m-spec" class="mt-1 inline-flex px-2 py-0.5 bg-blue-100 text-blue-800 border border-blue-300 rounded-full text-xs"></div>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        @foreach([
                            ['m-tel',    'Téléphone',   'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                            ['m-email',  'Email',       'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                            ['m-cat',    'Catégorie',   'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                            ['m-exp',    'Expérience',  'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                            ['m-statut', 'Statut',      'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ] as [$id, $label, $path])
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wide">{{ $label }}</p>
                                <p id="{{ $id }}" class="text-xs text-blue-900 mt-0.5"></p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function showMedecin(row) {
    const id = row.dataset.medecin;
    document.querySelectorAll('#tbody-medecins tr').forEach(r =>
        r.classList.remove('bg-blue-100', 'border-l-2', 'border-blue-500'));
    row.classList.add('bg-blue-100', 'border-l-2', 'border-blue-500');

    fetch(`/medecin/${id}`)
        .then(r => r.json())
        .then(data => {
            const initials = ((data.nom?.[0] ?? '') + (data.prenom?.[0] ?? '')).toUpperCase();
            document.getElementById('m-avatar').textContent  = initials;
            document.getElementById('m-name').textContent   = (data.prenom ?? '') + ' ' + (data.nom ?? '');
            document.getElementById('m-spec').textContent   = data.specialite ?? '-';
            document.getElementById('m-tel').textContent    = data.telephone ?? '-';
            document.getElementById('m-email').textContent  = data.user?.email ?? '-';
            document.getElementById('m-cat').textContent    = data.categorie ?? '-';
            document.getElementById('m-exp').textContent    = data.experience ?? '-';
            document.getElementById('m-statut').textContent = data.statut_dispo ?? '-';
            document.getElementById('panel-empty').classList.add('hidden');
            document.getElementById('panel-content').classList.remove('hidden');
        })
        .catch(err => console.error('Erreur fetch:', err));
}
</script>
@endsection