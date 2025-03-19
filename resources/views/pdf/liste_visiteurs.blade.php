<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des visiteurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            color: #27ae60;
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
        }
        td {
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Liste des visiteurs médicaux</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>CP</th>
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
                <td>{{ $visiteur['dateEmbauche'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Document généré le {{ date('d/m/Y') }} - GSB Frais
    </div>
</body>
</html> 