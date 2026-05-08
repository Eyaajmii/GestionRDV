@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white border border-blue-200 rounded-2xl p-8">

        <div class="flex items-center gap-3 mb-7 pb-5 border-b border-blue-100">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5h2m-1-1v2m-7 6h14M5 19h14"/>
                </svg>
            </div>

            <div>
                <h2 class="text-base font-medium text-blue-900">
                    Modifier médecin
                </h2>
                <p class="text-xs text-blue-400 mt-0.5">
                    Modifiez les informations du médecin
                </p>
            </div>
        </div>

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            @foreach($errors->all() as $e)
                <p>{{ $e }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST"
              action="{{ route('medecin.update', $medecin->id) }}"
              class="space-y-5">

            @csrf
            @method('PUT')

            <div class="border border-blue-200 rounded-xl overflow-hidden">

                <div class="flex items-center gap-2.5 px-4 py-3 bg-blue-50 border-b border-blue-200">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 11c0 1.657-1.343 3-3 3S6 12.657 6 11s1.343-3 3-3 3 1.343 3 3zm6 8v-1a4 4 0 00-4-4H8a4 4 0 00-4 4v1"/>
                    </svg>

                    <span class="text-sm font-medium text-blue-800">
                        Compte utilisateur
                    </span>
                </div>

                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Nom utilisateur
                        </label>

                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>

                            <input type="text"
                                   name="name"
                                   value="{{ $medecin->user->name }}"
                                   placeholder="Nom utilisateur"
                                   class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Email
                        </label>

                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-400"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/>
                            </svg>

                            <input type="email"
                                   name="email"
                                   value="{{ $medecin->user->email }}"
                                   placeholder="email@exemple.com"
                                   class="w-full pl-10 pr-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                        </div>
                    </div>

                </div>
            </div>

            <div class="border border-blue-200 rounded-xl overflow-hidden">

                <div class="flex items-center gap-2.5 px-4 py-3 bg-blue-50 border-b border-blue-200">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    </svg>

                    <span class="text-sm font-medium text-blue-800">
                        Informations médicales
                    </span>
                </div>

                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Nom
                        </label>

                        <input type="text"
                               name="nom"
                               value="{{ $medecin->nom }}"
                               placeholder="Nom"
                               class="w-full px-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Prénom
                        </label>

                        <input type="text"
                               name="prenom"
                               value="{{ $medecin->prenom }}"
                               placeholder="Prénom"
                               class="w-full px-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Spécialité
                        </label>

                        <input type="text"
                               name="specialite"
                               value="{{ $medecin->specialite }}"
                               placeholder="Spécialité"
                               class="w-full px-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Téléphone
                        </label>

                        <input type="text"
                               name="telephone"
                               value="{{ $medecin->telephone }}"
                               placeholder="Téléphone"
                               class="w-full px-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Email professionnel
                        </label>

                        <input type="email"
                               name="emailPro"
                               value="{{ $medecin->emailPro }}"
                               placeholder="Email professionnel"
                               class="w-full px-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Catégorie
                        </label>

                        <input type="text"
                               name="categorie"
                               value="{{ $medecin->categorie }}"
                               placeholder="Catégorie"
                               class="w-full px-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Expérience
                        </label>

                        <input type="text"
                               name="experience"
                               value="{{ $medecin->experience }}"
                               placeholder="Expérience"
                               class="w-full px-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wide mb-1.5">
                            Statut disponibilité
                        </label>

                        <select name="statut_dispo"
                                class="w-full px-3 py-2.5 bg-blue-50 border border-blue-300 rounded-lg text-sm text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition">

                            <option value="disponible"
                                {{ $medecin->statut_dispo == 'disponible' ? 'selected' : '' }}>
                                Disponible
                            </option>

                            <option value="indisponible"
                                {{ $medecin->statut_dispo == 'indisponible' ? 'selected' : '' }}>
                                Indisponible
                            </option>

                        </select>
                    </div>

                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-blue-100">

                <a href="{{ route('medecin.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 border border-blue-300 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-lg transition-colors">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>

                    Annuler
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>

                    Sauvegarder
                </button>

            </div>

        </form>
    </div>
</div>
@endsection