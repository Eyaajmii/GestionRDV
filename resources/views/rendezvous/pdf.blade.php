<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #c0392b;
            border-bottom: 2px solid #c0392b;
            padding-bottom: 10px;
        }

        .info {
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background-color: #2c3e50;
            color: white;
        }

        th,
        td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .planifie {
            background: #3498db;
            color: white;
        }

        .confirme {
            background: #27ae60;
            color: white;
        }

        .annule {
            background: #e74c3c;
            color: white;
        }

        .termine {
            background: #95a5a6;
            color: white;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #aaa;
        }
    </style>
</head>

<body>

    <h1>Récapitulatif des Rendez-vous</h1>

    <div class="info">
        <strong>Patient :</strong> {{ $patient->nom }} {{ $patient->prenom }}<br>
        <strong>Généré le :</strong> {{ now()->format('d/m/Y à H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Médecin</th>
                <th>Spécialité</th>
                <th>Motif</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rendezvous as $rdv)
            @php
            $statutVal = $rdv->statut instanceof \App\Models\StatutRdv
            ? $rdv->statut->value
            : (string) $rdv->statut;
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</td>
                <td>{{ $rdv->heure }}</td>
                <td>Dr. {{ $rdv->medecin->nom }} {{ $rdv->medecin->prenom }}</td>
                <td>{{ $rdv->medecin->specialite }}</td>
                <td>{{ $rdv->motif }}</td>
                <td>
                    <span class="badge {{ $statutVal }}">
                        {{ ucfirst($statutVal) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#aaa;">
                    Aucun rendez-vous trouvé.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Centre Médical — Plateforme de Réservation Médicale
    </div>

</body>

</html>