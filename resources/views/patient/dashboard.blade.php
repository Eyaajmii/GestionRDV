@extends('layouts.app')

@section('content')

<h2>Dashboard Patient</h2>

<div class="row">
    <div class="col-md-6">
        <div class="card p-3">
            Mes RDV : {{ $stats['total_rdv'] }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3">
            RDV à venir : {{ $stats['prochains_rdv'] }}
        </div>
    </div>
</div>

@endsection