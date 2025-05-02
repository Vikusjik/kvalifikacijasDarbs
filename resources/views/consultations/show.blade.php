<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultācijas informācija</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8fb;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            height: 90px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #356b8c;
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
            position: absolute;
            top: 20px;
            right: 20px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        table th {
            background-color: #4a90e2;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #eef3f9;
        }

        .action-buttons {
            text-align: center;
            margin-top: 30px;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 8px;
            font-size: 16px;
            color: white;
            background-color: #4a90e2;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .action-buttons a:hover {
            background-color: #357ab8;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ asset('images/VT-logo.jpeg') }}" alt="Ventspils Tehnikums Logo">
        
    </div>

    <a href="{{ route('home') }}" class="back-btn">Atpakaļ uz sākumu</a>

    <div class="container">
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

        <h1>Konsultācija: {{ $consultation->date_time->format('d.m.Y H:i') }}</h1>
        <h2>Pieslēgtie studenti un tēmas</h2>

        @if ($consultation->users->isEmpty())
            <p style="text-align: center;">Nav pieslēgto studentu.</p>
        @else
            <table>
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

        <div class="action-buttons">
            <a href="{{ route('consultations.index') }}">Atpakaļ uz konsultācijām</a>
        </div>
    </div>

</body>
</html>
