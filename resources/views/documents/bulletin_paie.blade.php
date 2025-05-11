<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de Paie</title>
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
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h2>Bulletin de Paie - {{ 2025 }}</h2>
    <p><strong>Employé :</strong> {{ $employee->user->first_name }} {{ $employee->user->last_name }}</p>
    <p><strong>Poste :</strong> {{ $employee->typeEmployees->last()->type->type }}</p>
    <p><strong>Date d'embauche :</strong> {{ $employee->typeEmployees->last()->in_date->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Base</th>
                <th>Taux</th>
                <th>cnss</th>
                <th>Retenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                <td>{{ $payment->gross }}</td>
                <td>{{ $payment->income_tax }}</td>
                <td>{{ $payment->cnss }}</td>
                <td>{{ $payment->net }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
