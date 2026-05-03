@extends('layouts.app')

@section('content')

<h2>Prendre un rendez-vous</h2>

<form method="POST" action="{{ route('rendezvous.store') }}">
    @csrf

    <div class="mb-2">
        <label>Médecin</label>
        <select name="medecin_id" class="form-control">
            @foreach(\App\Models\Medecin::all() as $m)
                <option value="{{ $m->id }}">{{ $m->nom }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-2">
        <label>Date</label>
        <input type="date" name="date" class="form-control">
    </div>

    <div class="mb-2">
        <label>Heure</label>
        <input type="time" name="heure" class="form-control">
    </div>

    <div class="mb-2">
        <label>Motif</label>
        <textarea name="motif" class="form-control"></textarea>
    </div>

    <button class="btn btn-success">Valider</button>

</form>

@endsection