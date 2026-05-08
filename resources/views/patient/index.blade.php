@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">

    {{-- En-tête --}}
    <div class="flex justify-between items-start mb-7">
        <div>
            <h1 class="text-xl font-medium text-blue-900">Liste des patients</h1>
            <p class="text-sm text-blue-400 mt-1">Consultez et gérez les dossiers patients</p>
        </div>
        <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 border border-blue-300 text-xs font-medium px-3 py-1.5 rounded-full">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
            </svg>
            {{ $patients->count() }} patients
        </span>
    </div>

    <div class="flex gap-5 items-start">

        {{-- Tableau --}}
        <div class="flex-1 min-w-0">
            <div class="bg-white border border-blue-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 border-b border-blue-200">
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Nom</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Prénom</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Téléphone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wide">Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-100" id="tbody-patients">
                        @forelse($patients as $patient)
                        <tr data-patient="{{ $patient->id }}"
                            onclick="showPatient(this)"
                            class="hover:bg-blue-50/50 transition-colors cursor-pointer group">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-xs font-medium text-blue-800 flex-shrink-0">
                                        {{ strtoupper(substr($patient->nom, 0, 1) . substr($patient->prenom, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-blue-900">{{ $patient->nom }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $patient->prenom }}</td>
                            <td class="px-4 py-3 text-blue-500 text-xs">{{ $patient->telephone }}</td>
                            <td class="px-4 py-3 text-blue-500 text-xs">{{ $patient->user->email ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-10">
                                <svg class="w-10 h-10 text-blue-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-sm text-blue-300">Aucun patient trouvé</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Panneau latéral --}}
        <div class="w-64 flex-shrink-0" id="side-panel">
            <div class="bg-white border border-blue-200 rounded-xl overflow-hidden">

                {{-- État vide --}}
                <div id="panel-empty" class="py-10 px-4 text-center">
                    <svg class="w-10 h-10 text-blue-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-xs text-blue-300">Cliquez sur un patient<br>pour voir ses détails</p>
                </div>

                {{-- Contenu patient --}}
                <div id="panel-content" class="hidden">
                    <div class="bg-blue-50 px-4 py-4 border-b border-blue-200 flex items-center gap-3">
                        <div id="p-avatar"
                            class="w-10 h-10 rounded-full bg-blue-200 border border-blue-300 flex items-center justify-center text-sm font-medium text-blue-800 flex-shrink-0">
                        </div>
                        <div>
                            <div id="p-name" class="text-sm font-medium text-blue-900"></div>
                            <div class="text-xs text-blue-400 mt-0.5">Fiche patient</div>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wide">Téléphone</p>
                                <p id="p-tel" class="text-xs text-blue-900 mt-0.5"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wide">Date de naissance</p>
                                <p id="p-dob" class="text-xs text-blue-900 mt-0.5"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wide">Adresse</p>
                                <p id="p-addr" class="text-xs text-blue-900 mt-0.5"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wide">Email</p>
                                <p id="p-email" class="text-xs text-blue-900 mt-0.5 break-all"></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    function showPatient(row) {
        const id = row.dataset.patient;

        document.querySelectorAll('#tbody-patients tr').forEach(r => {
            r.classList.remove('bg-blue-100', 'border-l-2', 'border-blue-500');
        });
        row.classList.add('bg-blue-100', 'border-l-2', 'border-blue-500');

        fetch(`/patients/${id}`)
            .then(r => r.json())
            .then(data => {
                const initials = ((data.nom?.[0] ?? '') + (data.prenom?.[0] ?? '')).toUpperCase();
                document.getElementById('p-avatar').textContent  = initials;
                document.getElementById('p-name').textContent   = (data.prenom ?? '') + ' ' + (data.nom ?? '');
                document.getElementById('p-tel').textContent    = data.telephone ?? '-';
                document.getElementById('p-dob').textContent    = data.date_naissance ?? '-';
                document.getElementById('p-addr').textContent   = data.adresse ?? '-';
                document.getElementById('p-email').textContent  = data.user?.email ?? '-';

                document.getElementById('panel-empty').classList.add('hidden');
                document.getElementById('panel-content').classList.remove('hidden');
            })
            .catch(err => console.error('Erreur fetch:', err));
    }
</script>
@endsection