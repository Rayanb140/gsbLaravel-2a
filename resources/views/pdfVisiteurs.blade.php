<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Liste des visiteurs</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            color: #1D2941;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th {
            background-color: #E9F1FE;
            padding: 5px;
            text-align: left;
        }
        td {
            padding: 5px;
        }
        .date {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Liste des visiteurs</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Code postal</th>
                <th>Ville</th>
                <th>Date d'embauche</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lesVisiteurs as $visiteur)
            <tr>
                <td>{{ $visiteur['id'] }}</td>
                <td>{{ $visiteur['nom'] }}</td>
                <td>{{ $visiteur['prenom'] }}</td>
                <td>{{ $visiteur['adresse'] }}</td>
                <td>{{ $visiteur['cp'] }}</td>
                <td>{{ $visiteur['ville'] }}</td>
                <td class="date">{{ \Carbon\Carbon::parse($visiteur['dateEmbauche'])->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Date d'édition : {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</body>
</html> 