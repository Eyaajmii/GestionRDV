@extends('layouts.medecin')

@section('content')

<h2>Dashboard Médecin</h2>

<div class="row">
    <div class="col-md-4">
        <div class="card p-3">
            Total RDV : {{ $stats['total_rdv'] }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            RDV aujourd'hui : {{ $stats['rdv_today'] }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            RDV à venir : {{ $stats['prochains_rdv'] }}
        </div>
    </div>
</div>

@endsection