<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ventspils Tehnikums 2 - Skolotāju lapa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f2ff;
            background-image: url('images/VT-eka.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: flex-start;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
        }
        .logo {
            max-width: 120px;
            height: auto;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        nav a, nav button {
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            border: 1px solid #ddd;
            transition: all 0.3s ease-in-out;
            background-color: white;
            cursor: pointer;
        }

        nav a:hover, nav button:hover {
            background-color: #007bff;
            color: white;
            border-color: #0056b3;
        }

        .logout-form {
            margin-top: 30px;
        }

        .logout-form input {
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-form input:hover {
            background-color: #c9302c;
        }

        .notification {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
            position: relative;
        }

        .notification strong {
            display: block;
            margin-bottom: 5px;
        }

        .notification small {
            display: block;
            color: #555;
        }

        .notification-title {
            font-size: 1.2em;
            margin-bottom: 10px;
            text-align: left;
            font-weight: bold;
        }

        .notification-list {
            margin-top: 20px;
        }

        .notification-list a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.1em;
        }

        .notification-list a:hover {
            text-decoration: underline;
        }

        .section-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 20px;
            color: #333;
            text-align: left;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 1.2em;
            color: #aaa;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logotips -->
        <div class="logo-container">
            <img src="images/VT-logo.jpeg" alt="Ventspils Tehnikums Logo" class="logo">
        </div>

        <!-- Skolotāju lapa -->
        <h1>Skolotāju lapa</h1>

        <!-- Navigācija -->
        <nav>
            <a href="{{ route('consultations.create') }}">Pievienot konsultāciju</a>
            <a href="{{ route('consultations.index') }}">Konsultāciju saraksts</a>
        </nav>

        <!-- Logout poga -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <input type="submit" value="Izrakstīties">
        </form>

        <!-- Paziņojumi (Notifications) Section -->
        <div class="section-title">Paziņojumi</div>

        <!-- Saraksts ar anulētām konsultācijām -->
        <div class="notification-list">
            @foreach(auth()->user()->notifications as $notification)
            <div class="notification">
                <!-- dzešanas forma -->
                <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="close-btn">&times;</button>
                </form>
                
                
                <div class="notification-title">
                    <strong>{{ $notification->data['student_name'] ?? 'Nezināms students' }}</strong>
                </div>
                <small>Konsultācija: {{ \Carbon\Carbon::parse($notification->data['consultation_date'])->format('d.m.Y H:i') }}</small>
                <small>Iemesls: {{ $notification->data['reason'] ?? 'Nav norādīts iemesls' }}</small>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
