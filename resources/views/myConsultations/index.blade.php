<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manas konsultācijas</title>
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

        .action-buttons button {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            background-color: #007bff;
        }

        .action-buttons button:hover {
            background-color: #0056b3;
        }

        .reason-form {
            display: none;
            margin-top: 10px;
        }

        .reason-form textarea, .reason-form button {
            margin-top: 10px;
            width: 100%;
        }

        .reason-form button {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .reason-form button:hover {
            background-color: #c9302c;
        }

        .back-btn {
            text-decoration: none;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
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

        <a href="{{ route('home') }}" class="back-btn">Atpakaļ uz sākumu</a>
        <h1>Manas konsultācijas</h1>

        @if($myConsultations->isEmpty())
            <p>Jūs neesat pieteicies nevienai konsultācijai.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Datums un laiks</th>
                        <th>Izveidoja</th>
                        <th>Tēma</th>
                        <th>Darbības</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myConsultations as $consultation)
                        <tr>
                            <td>{{ $consultation->date_time->format('d.m.Y H:i') }}</td>
                            <td>{{ $consultation->creator->name ?? 'Nezināms' }}</td>
                            <td>{{ $consultation->pivot->topic ?? 'Nav norādīts' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="toggle-reason-btn" data-id="{{ $consultation->id }}">Atteikties</button>
                                </div>

                                <!-- Paslēpta atteikšanās forma -->
                                <form id="reason-form-{{ $consultation->id }}" class="reason-form" action="{{ route('myConsultation.cancel', $consultation->id) }}" method="POST">
                                    @csrf
                                    <textarea name="reason" placeholder="Norādiet iemeslu" required></textarea>
                                    <button type="submit">Apstiprināt</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.toggle-reason-btn');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const consultationId = button.getAttribute('data-id');
                    const form = document.getElementById(`reason-form-${consultationId}`);
                    form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
                });
            });
        });
    </script>
</body>
</html>
