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
    margin-bottom: 20px;
    color: #356b8c;
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

        .actions {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
}

        .actions a {
    text-decoration: none;
    background-color: #4a90e2;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

        .actions a:hover {
    background-color: #357ab8;
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
    margin-top: 10px;
}

        .action-buttons button,
        .action-buttons a {
    text-decoration: none;
    padding: 10px 16px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: bold;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

        .action-buttons a {
    background-color: #4a90e2;
}

        .action-buttons a:hover {
    background-color: #357ab8;
}

        .action-buttons button {
    background-color: #d9534f;
}

        .action-buttons button:hover {
    background-color: #c9302c;
}

        .reason-form, .edit-form {
    margin-top: 10px;
    display: none;
}

        .reason-form textarea,
        .edit-form input,
        .edit-form select {
    width: 100%;
    padding: 8px;
    margin: 8px 0;
    border-radius: 6px;
    border: 1px solid #ccc;
}

        .reason-form button,
        .edit-form button {
    background-color: #4a90e2;
    color: white;
    font-weight: bold;
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

        .reason-form button:hover,
        .edit-form button:hover {
    background-color: #357ab8;
}

    </style>
</head>
<body>
    
    <div class="header">
        <img src="{{ asset('images/VT-logo.jpeg') }}" alt="Ventspils Tehnikums Logo">
       <h1>Pieteiktās konsultācijas</h1>
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
