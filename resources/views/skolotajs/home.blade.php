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
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            color: #007bff;
            margin: 0;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        nav a {
            text-decoration: none;
            background-color: white;
            color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            border: 1px solid #ddd;
            transition: all 0.3s ease-in-out;
        }

        nav a:hover {
            background-color: #007bff;
            color: white;
            border-color: #0056b3;
        }

        .logout-form {
            margin-top: 20px;
        }

        .logout-form input {
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .logout-form input:hover {
            background-color: #c9302c;
        }

        .notifications {
            margin-top: 30px;
            text-align: left;
        }

        .notification {
            background-color: #fff8e1;
            border-left: 5px solid #ffc107;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 15px;
        }

        .clear-btn {
            margin-top: 10px;
            text-align: right;
        }

        .clear-btn form button {
            background-color: #f0ad4e;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .clear-btn form button:hover {
            background-color: #ec971f;
        }

        .no-notifications {
            color: #333;
            font-size: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .delete-all-btn {
            background-color: #f0ad4e;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 15px;
        }

        .delete-all-btn:hover {
            background-color: #ec971f;
        }

        .delete-btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .delete-all-btn-container {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Skolotāju lapa</h1>
        </div>

        <!-- Navigācija -->
        <nav>
            <a href="{{ route('consultations.create') }}">Pievienot konsultāciju</a>
            <a href="{{ route('consultations.index') }}">Konsultāciju saraksts</a>
        </nav>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <input type="submit" value="Izrakstīties">
        </form>

        <!-- Paziņojumi (Notifications) -->
        <div class="notifications">
            <div class="delete-btn-container">
                <h3>Paziņojumi</h3>
                <!-- Izdzēst visus paziņojumus -->
                <form method="POST" action="{{ route('notifications.clear') }}" class="delete-all-btn-container">
                    @csrf
                    <button type="submit" class="delete-all-btn">Notīrīt paziņojumus</button>
                </form>
            </div>

            <!-- Parbauda pazinojumu pieejamibu -->
            @forelse(auth()->user()->notifications as $notification)
                <div class="notification">
                    <div class="notification-title">
                        <strong>{{ $notification->data['student_name'] ?? 'Nezināms students' }}</strong>
                    </div>
                    <small>Konsultācija: {{ \Carbon\Carbon::parse($notification->data['consultation_date'])->format('d.m.Y H:i') }}</small>
                    <small>Iemesls: {{ $notification->data['reason'] ?? 'Nav norādīts iemesls' }}</small>
                </div>
            @empty
                <div class="no-notifications">Nav jaunu paziņojumu.</div>
            @endforelse
        </div>
    </div>
</body>
</html>
