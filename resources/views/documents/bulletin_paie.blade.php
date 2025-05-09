<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de Paie</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h2>Bulletin de Paie - {{ mois }} {{ annee }}</h2>
    <p><strong>Employé :</strong> {{ employe_nom }}</p>
    <p><strong>Poste :</strong> {{ poste }}</p>
    <p><strong>Matricule :</strong> {{ matricule }}</p>
    <p><strong>Date d'embauche :</strong> {{ date_embauche }}</p>
    <p><strong>CNSS :</strong> {{ cnss }}</p>
    <p><strong>CIMR :</strong> {{ cimr }}</p>

    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Base</th>
                <th>Taux</th>
                <th>Gain</th>
                <th>Retenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($elements as $element)
            <tr>
                <td>{{ $element['libelle'] }}</td>
                <td>{{ $element['base'] }}</td>
                <td>{{ $element['taux'] }}</td>
                <td>{{ $element['gain'] }}</td>
                <td>{{ $element['retenue'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Salaire Net à Payer :</strong> {{ salaire_net }} MAD</p>
</body>
</html>
