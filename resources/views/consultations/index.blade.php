<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konsultācijas</title>
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
            height: 80px; /* Palielināts logotipa izmērs */
            width: auto; /* Saglabā attiecību */
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
            text-align: left;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('images/VT-logo.jpeg') }}" alt="Ventspils Tehnikums Logo">
        <h1>Konsultāciju saraksts</h1>
    </div>

    <!-- Container -->
    <div class="container">
        <!-- Actions -->
        @if(Auth::user()->usertype === 'admin')
            <div class="actions">
                <a href="{{ route('consultations.create') }}">Uztaisīt konsultāciju</a>
                <a href="{{ url('/home') }}">Atpakaļ</a>
            </div>
        @else
            <a href="{{ url('/home') }}" class="btn">Atpakaļ</a>
        @endif

        <!-- Konsultāciju saraksts -->
        <table>
            <thead>
                <tr>
                    <th>Datums un laiks</th> <!-- Pārsauktā kolonna "Tēma" uz "Datums un laiks" -->
                    <th>Darbības</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultations as $consultation)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($consultation->date_time)->format('d.m.Y H:i') }}</td> <!-- Parādām datumu un laiku -->
                        <td class="action-buttons">
                            @if (Auth::user()->usertype === 'admin')
                                <a href="{{ route('consultations.edit', $consultation->id) }}">Rediģēt</a>
                                <form action="{{ route('consultations.destroy', $consultation->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Vai esat pārliecināts?')">Dzēst</button>
                                </form>
                            @else
                            <form action="{{ route('consultations.register.form', $consultation->id) }}" method="GET" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn">Pieteikties konsultācijai</button>
                            </form>
                            
                            @endif
                                @if (session('success'))
                                    <div class="success">
                                    {{ session('success') }}
                                    </div>
                                 @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
