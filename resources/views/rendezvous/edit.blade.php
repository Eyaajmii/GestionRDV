@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4">Modifier le rendez-vous</h2>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Erreurs validation --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <form action="{{ route('rendezvous.update', $rdv->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Date --}}
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date"
                   name="date"
                   class="form-control"
                   value="{{ old('date', $rdv->date) }}"
                   required>
        </div>

        {{-- Heure --}}
        <div class="mb-3">
            <label class="form-label">Heure</label>
            <input type="time"
                   name="heure"
                   class="form-control"
                   value="{{ old('heure', $rdv->heure) }}"
                   required>
        </div>

        {{-- Motif --}}
        <div class="mb-3">
            <label class="form-label">Motif</label>
            <textarea name="motif"
                      class="form-control"
                      rows="3"
                      required>{{ old('motif', $rdv->motif) }}</textarea>
        </div>

        {{-- Boutons --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Mettre à jour
            </button>

            <a href="{{ route('rendezvous.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>

    </form>
</div>

@endsection