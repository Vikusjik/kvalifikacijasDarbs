<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konsultācijas</title>
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
            width: auto;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            text-align: center; 
            flex-grow: 1; 
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
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

        .action-buttons button {
            background-color: #d9534f;
            padding: 8px 15px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .action-buttons button:hover {
            background-color: #c9302c;
        }

    </style>
</head>
<body>

    <div class="header">
        <img src="{{ asset('images/VT-logo.jpeg') }}" alt="Ventspils Tehnikums Logo">
        <h1>Konsultāciju saraksts</h1>
    </div>

    <a href="{{ route('home') }}" class="back-btn">Atpakaļ uz sākumu</a>

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

        <table>
            <thead>
                <tr>
                    <th>Skolotājs</th>
                    <th>Datums un laiks</th>
                    <th>Darbības</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultations as $consultation)
                    <tr>
                        <td>{{ $consultation->creator->name ?? 'Nezināms' }}</td>
                        <td>{{ $consultation->date_time->format('d.m.Y H:i') }}</td>
                        <td class="action-buttons">
                            @if(Auth::user()->usertype === 'admin')
                                <a href="{{ route('consultations.edit', $consultation->id) }}" class="btn">Rediģēt</a>

                                <form action="{{ route('consultations.destroy', $consultation->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Vai tiešām vēlaties dzēst šo konsultāciju?')">Dzēst</button>
                                </form>
                                
                                <a href="{{ route('consultations.show', $consultation->id) }}">Pieteiktie skolēni</a>
                            @else
                                @if(!$consultation->users->contains('id', auth()->id()))
                                    <button onclick="toggleForm({{ $consultation->id }})">Pieteikties</button>
                                    <form method="POST" action="{{ route('consultations.register.submit', $consultation->id) }}" id="form-{{ $consultation->id }}" class="topic-form">
                                        @csrf
                                        <input type="text" id="topic" name="topic" placeholder="Ievadiet tēmu" required>
                                        <button type="submit">Apstiprināt</button>
                                    </form>
                                @else
                                    <span>Jūs jau esat pieteicies</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function toggleForm(consultationId) {
            var form = document.getElementById('form-' + consultationId);
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    </script>

</body>
</html>
