<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Attestation de Stage</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 200px 60px 100px;
            font-size: 22px;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .inner {
            width: 100%;
            line-height: 1.8;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 26px;
            margin-bottom: 30px;
        }

        .signature {
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="inner">
            <p class="title">Attestation de stage</p>

            <p>
                Nous soussignés, la société {{ $enterprise->name }},
                certifions par la présente que Monsieur/Madame <strong>{{ ucfirst($employee->user->first_name) }}
                    {{ ucfirst($employee->user->last_name) }}</strong><br>
                demeurant au
                <strong>{{ $employee->address }}</strong>,<br>
                CIN : <strong>{{ $employee->cin }}</strong> a effectué un stage au sein de notre entreprise <strong>{{ $enterprise->name }}</strong>
                du <strong>{{ $employee->typeEmployees()->firstWhere('type_id',$trainee_type_id)->in_date->format('d/m/Y') }}</strong>
                au
                <strong>{{ $employee->typeEmployees->last()->out_date ? $employee->typeEmployees()->firstWhere('type_id',$trainee_type_id)->out_date->format('d/m/Y') : 'Actuallement' }}</strong>
                en qualité
                <strong>{{'..................................................'}}</strong> .
            </p>

            <p>
                Cette attestation est délivrée à l’intéressé(e) pour servir et valoir ce que de droit.
            </p>

            <p class="signature">
                Fait le : {{ now()->format('d/m/Y') }}
            </p>
        </div>
    </div>
</body>

</html>