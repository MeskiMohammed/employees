<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Attestation de Congés</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 200px 60px 100px;
            /* top, right/left, bottom (to leave room for header/footer) */
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
            <p class="title">Attestation de congé</p>

            <p>Nous soussignés, la société {{ $enterprise->name }}, attestons que :
                <strong>{{ $employee->user->first_name . ' ' . $employee->user->last_name }}</strong>,
                titulaire de la CIN n° {{ $employee->cin }}, occupe le poste de
                {{ $employee->typeEmployees->last()->type->type }} au sein de notre entreprise depuis le
                {{ $employee->typeEmployees->last()->in_date->format('d/m/Y') }}.
                Il/Elle a bénéficié d'un congé du {{ $leave->start_date->format('d/m/Y') }} au
                {{ $leave->end_date->format('d/m/Y') }}.
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