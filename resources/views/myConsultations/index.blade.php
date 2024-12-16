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

        .reason-form {
            display: none;
        }

        .edit-form {
            display: none;
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

        <!-- Poga "Atpakaļ uz sākumu" labajā pusē -->
        <a href="{{ route('home') }}" class="back-btn">Atpakaļ uz sākumu</a>
        <h1>Manas konsultācijas</h1>
        
        @if($myConsultations->isEmpty())
            <p>Jūs neesat pieteicies nevienai konsultācijai.</p>
        @else
        <ul>
            @foreach($myConsultations as $consultation)
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
                    <tr>
                        <td>{{ $consultation->date_time->format('d.m.Y H:i') }}</td>
                        <td>{{ $consultation->creator->name ?? 'Nezināms' }}</td>
                        <td>{{ $consultation->pivot->topic ?? 'Nav norādīts' }}</td>
                        <td>
                            <!-- Darbības -->
                            @if($consultation->is_active)
                                <div class="action-buttons">
                                    <button class="edit-btn" data-id="{{ $consultation->id }}">Rediģēt</button>
                                    <button class="toggle-reason-btn" data-id="{{ $consultation->id }}">Atteikties</button>

                                    <!-- Paslēpta dzēšanas forma-->
                                    <form id="reason-form-{{ $consultation->id }}" class="reason-form" action="{{ route('myConsultation.cancel', $consultation->id) }}" method="POST" style="display: none; margin-top: 10px;">
                                        @csrf
                                        <textarea name="reason" placeholder="Norādiet iemeslu" required></textarea>
                                        <button type="submit" class="btn">Apstiprināt</button>
                                    </form>

                                    <!-- Paslēpta rediģēšanas forma-->
                                    <form id="edit-form-{{ $consultation->id }}" class="edit-form" action="{{ route('myConsultation.update', $consultation->id) }}" method="POST" style="display: none; margin-top: 10px;">
                                        @csrf
                                        @method('PUT')

                                        <!-- Tēmas rediģēšanas lauks -->
                                        <label for="topic-{{ $consultation->id }}">Jauna tēma:</label>
                                        <input type="text" id="topic-{{ $consultation->id }}" name="topic" value="{{ $consultation->pivot->topic ?? '' }}" required>

                                        <!-- Dropdown ar konsultācijām -->
                                        <label for="new_consultation-{{ $consultation->id }}">Izvēlieties citu laiku:</label>
                                        <select id="new_consultation-{{ $consultation->id }}" name="new_consultation_id" required>
                                            <option value="">Izvēlieties konsultāciju</option>
                                            @foreach($availableConsultations as $available)
                                                <option value="{{ $available->id }}" {{ $available->id == $consultation->id ? 'selected' : '' }}>
                                                    {{ $available->date_time->format('d.m.Y H:i') }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit">Saglabāt</button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @endforeach
        </ul>
        @endif
    </div>

</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Visas pogas
        const toggleButtons = document.querySelectorAll('.toggle-reason-btn');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Saņēmam konsultācijas ID no data-id
                const consultationId = button.getAttribute('data-id');
                
                // Atrodam atbilstošo formu
                const form = document.getElementById(`reason-form-${consultationId}`);
                
                // Mainām formas redzamību
                if (form.style.display === 'none' || form.style.display === '') {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const consultationId = button.getAttribute('data-id');
                const form = document.getElementById(`edit-form-${consultationId}`);
                form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
            });
        });
    });
</script>

</html>
