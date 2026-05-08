@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white border border-blue-200 rounded-2xl p-8">
        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-blue-100">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-medium text-blue-900">Créer un médecin</h2>
                <p class="text-xs text-blue-400 mt-0.5">Remplissez les informations du nouveau médecin</p>
            </div>
        </div>

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('medecin.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="role" value="medecin">

            <div class="border border-blue-200 rounded-xl overflow-hidden">
                <div class="flex items-center gap-2.5 px-4 py-3 bg-blue-50 border-b border-blue-200">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span class="text-sm font-medium text-blue-800">Compte utilisateur</span>
                </div>
                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Nom</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <input type="text" name="name" required placeholder="Nom complet"
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Email</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <input type="email" name="email" required placeholder="email@exemple.com"
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Mot de passe</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <input type="password" name="password" required placeholder="••••••••"
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Confirmer mot de passe</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <input type="password" name="password_confirmation" required placeholder="••••••••"
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                </div>
            </div>

            <div class="border border-blue-200 rounded-xl overflow-hidden">
                <div class="flex items-center gap-2.5 px-4 py-3 bg-blue-50 border-b border-blue-200">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span class="text-sm font-medium text-blue-800">Informations médicales</span>
                </div>
                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Prénom</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <input type="text" name="prenom" placeholder="Prénom"
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Téléphone</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <input type="text" name="telephone" placeholder="XX XXX XXX"
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">Spécialité</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <input type="text" name="specialite" value="generaliste" placeholder="ex: Cardiologie"
                                class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-blue-100">
                <a href="{{ route('medecin.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 border border-blue-300 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Annuler
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Créer le médecin
                </button>
            </div>

        </form>
    </div>
</div>
@endsection