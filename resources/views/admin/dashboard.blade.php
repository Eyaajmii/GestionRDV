@extends('layouts.admin')

@section('content')

<h2>Dashboard Admin</h2>

<div class="row">

    <div class="col-md-3">
        <div class="card p-3 bg-primary text-white">
            Médecins : {{ $stats['medecins'] }}
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 bg-success text-white">
            Patients : {{ $stats['patients'] }}
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 bg-warning text-white">
            RDV : {{ $stats['rdv'] }}
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 bg-danger text-white">
            Aujourd'hui : {{ $stats['rdv_today'] }}
        </div>
    </div>

</div>

@endsection