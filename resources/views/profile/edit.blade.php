@extends('layouts.app')

@section('header')
Mon Profil
@endsection

@section('content')
<div class="py-10">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="p-6 bg-white shadow sm:rounded-xl border border-gray-100">
            <h3 class="text-base font-semibold text-gray-800 mb-4">
                Informations du compte
            </h3>
            @include('profile.partials.update-profile-information-form')
        </div>

        @if(auth()->user()->patient)
        <div class="p-6 bg-white shadow sm:rounded-xl border border-gray-100">
            <h3 class="text-base font-semibold text-gray-800 mb-4">
                Informations patient
            </h3>
            <form method="POST" action="{{ route('patients.update', auth()->user()->patient->id) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nom" value="Nom" />
                        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full"
                            :value="old('nom', auth()->user()->patient->nom)" required />
                    </div>
                    <div>
                        <x-input-label for="prenom" value="Prénom" />
                        <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full"
                            :value="old('prenom', auth()->user()->patient->prenom)" required />
                    </div>
                    <div>
                        <x-input-label for="telephone" value="Téléphone" />
                        <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full"
                            :value="old('telephone', auth()->user()->patient->telephone)" />
                    </div>
                    <div>
                        <x-input-label for="date_naissance" value="Date de naissance" />
                        <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-1 block w-full"
                            :value="old('date_naissance', auth()->user()->patient->date_naissance)" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="adresse" value="Adresse" />
                        <x-text-input id="adresse" name="adresse" type="text" class="mt-1 block w-full"
                            :value="old('adresse', auth()->user()->patient->adresse)" />
                    </div>
                </div>
                <div class="flex items-center gap-4 pt-2">
                    <x-primary-button>Enregistrer</x-primary-button>
                    @if(session('status') === 'patient-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600">✓ Sauvegardé.</p>
                    @endif
                </div>
            </form>
        </div>
        @endif

        @if(auth()->user()->medecin)
        <div class="p-6 bg-white shadow sm:rounded-xl border border-gray-100">
            <h3 class="text-base font-semibold text-gray-800 mb-4">
                Informations médecin
            </h3>
            <form method="POST" action="{{ route('medecins.update', auth()->user()->medecin->id) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="med_nom" value="Nom" />
                        <x-text-input id="med_nom" name="nom" type="text" class="mt-1 block w-full"
                            :value="old('nom', auth()->user()->medecin->nom)" required />
                    </div>
                    <div>
                        <x-input-label for="med_prenom" value="Prénom" />
                        <x-text-input id="med_prenom" name="prenom" type="text" class="mt-1 block w-full"
                            :value="old('prenom', auth()->user()->medecin->prenom)" required />
                    </div>
                    <div>
                        <x-input-label for="specialite" value="Spécialité" />
                        <x-text-input id="specialite" name="specialite" type="text" class="mt-1 block w-full"
                            :value="old('specialite', auth()->user()->medecin->specialite)" />
                    </div>
                    <div>
                        <x-input-label for="med_telephone" value="Téléphone" />
                        <x-text-input id="med_telephone" name="telephone" type="text" class="mt-1 block w-full"
                            :value="old('telephone', auth()->user()->medecin->telephone)" />
                    </div>
                    <div>
                        <x-input-label for="emailPro" value="Email professionnel" />
                        <x-text-input id="emailPro" name="emailPro" type="email" class="mt-1 block w-full"
                            :value="old('emailPro', auth()->user()->medecin->emailPro)" />
                    </div>
                    <div>
                        <x-input-label for="experience" value="Années d'expérience" />
                        <x-text-input id="experience" name="experience" type="number" class="mt-1 block w-full"
                            :value="old('experience', auth()->user()->medecin->experience)" />
                    </div>
                </div>
                <div class="flex items-center gap-4 pt-2">
                    <x-primary-button>Enregistrer</x-primary-button>
                    @if(session('status') === 'medecin-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-green-600">✓ Sauvegardé.</p>
                    @endif
                </div>
            </form>
        </div>
        @endif

        <div class="p-6 bg-white shadow sm:rounded-xl border border-gray-100">
            <h3 class="text-base font-semibold text-gray-800 mb-4">
                🔒 Changer le mot de passe
            </h3>
            @include('profile.partials.update-password-form')
        </div>

        <div class="p-6 bg-white shadow sm:rounded-xl border border-red-100">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</div>
@endsection