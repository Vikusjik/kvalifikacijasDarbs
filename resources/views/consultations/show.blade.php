<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultācijas informācija</title>
</head>
<body>
    <style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            height: 80px;
            width: auto;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .actions {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .actions a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .actions a:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons a, .action-buttons button {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .action-buttons a {
            background-color: #007bff;
        }

        .action-buttons a:hover {
            background-color: #0056b3;
        }

        .action-buttons button {
            background-color: #d9534f;
        }

        .action-buttons button:hover {
            background-color: #c9302c;
        }

        /* Atpakaļ uz sākumu poga - novieto to labajā pusē */
        .back-btn {
            text-decoration: none;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
            position: absolute;  /* Izvieto absolūti */
            right: 20px;  /* Pozicionē labajā pusē */
            top: 20px;    /* Ievieto poga nedaudz no augšas */
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        /* Hide the form by default */
        .topic-form {
            display: none;
            margin-top: 20px;
        }

        .topic-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>

        
    <div class="header">
        <img src="{{ asset('images/VT-logo.jpeg') }}" alt="Ventspils Tehnikums Logo">
        <h1>Konsultāciju saraksts</h1>
    </div>
    
    <div class="container">
        <!-- Parādīt sesijas ziņas -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Poga "Atpakaļ uz sākumu" labajā pusē -->
        <a href="{{ route('home') }}" class="back-btn">Atpakaļ uz sākumu</a>
    <h1>Konsultācija: {{ $consultation->date_time->format('d.m.Y H:i') }}</h1>

    <h2>Pieslēgtie studenti un tēmas</h2>

    @if ($consultation->users->isEmpty())
        <p>Nav pieslēgto studentu.</p>
    @else
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Students</th>
                    <th>Tēma</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultation->users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->pivot->topic }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class= "action-buttons">
    <a href="{{ route('consultations.index') }}">Atpakaļ uz konsultācijām</a>
</div>
</body>
</html>
