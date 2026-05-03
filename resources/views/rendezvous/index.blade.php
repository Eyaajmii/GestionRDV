@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Mes Rendez-vous</h1>
    <a href="{{ route('rendezvous.create') }}" class="btn btn-primary">
        Nouveau RDV
    </a>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Date</th>
            <th>Médecin</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($rdvs as $rdv)
        <tr>
            <td>
                {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}
                à {{ $rdv->heure }}
            </td>

            <td>
                Dr. {{ $rdv->medecin->nom ?? 'N/A' }}
            </td>

            <td>
                @if($rdv->statut == 'confirmé')
                    <span class="badge bg-success">Confirmé</span>
                @elseif($rdv->statut == 'annulé')
                    <span class="badge bg-danger">Annulé</span>
                @else
                    <span class="badge bg-secondary">{{ $rdv->statut }}</span>
                @endif
            </td>

            <td>
                <a href="{{ route('rendezvous.edit', $rdv->id) }}" 
                   class="btn btn-warning btn-sm">
                    Modifier
                </a>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="4" class="text-center">
                Aucun rendez-vous trouvé
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection