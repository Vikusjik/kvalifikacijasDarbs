<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Viktorijas Tehnikums - Skolotāju lapa</title>
    <style>
            body {
            font-family: Arial, sans-serif;
            background-color: #e6f2ff;
            background-image: url('images/VT-eka.png');
            background-size: 50%; 
            background-position: top center;
            background-repeat: no-repeat;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: flex-end;
        }


        .container {
            max-width: 900px;
            margin: 0 auto 40px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .header h1 {
            font-size: 26px;
            color: #336699;
            margin: 0 0 15px;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }

        nav a {
            text-decoration: none;
            background-color: #f2f2f2;
            color: #444;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            border: 1px solid #ccc;
            transition: all 0.3s ease-in-out;
        }

        nav a:hover {
            background-color: #336699;
            color: white;
            border-color: #2a4d73;
        }

        .logout-form input {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #cc6666;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .logout-form input:hover {
            background-color: #b94a48;
        }

        .notifications {
            margin-top: 30px;
            text-align: left;
        }

        .notification {
            background-color: #f8f9fa;
            border-left: 5px solid #90c2e7;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 15px;
        }

        .clear-btn,
        .delete-all-btn-container {
            text-align: right;
            margin-top: 10px;
        }

        .delete-all-btn {
            background-color: #6c91c2;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-all-btn:hover {
            background-color: #5877a3;
        }

        .no-notifications {
            color: #555;
            font-size: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .delete-btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Skolotāju lapa</h1>
        </div>

        <nav>
            <a href="{{ route('consultations.create') }}">Pievienot konsultāciju</a>
            <a href="{{ route('consultations.index') }}">Konsultāciju saraksts</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <input type="submit" value="Izrakstīties">
        </form>

        <div class="notifications">
            <div class="delete-btn-container">
                <h3>Paziņojumi</h3>
                <form method="POST" action="{{ route('notifications.clear') }}" class="delete-all-btn-container">
                    @csrf
                    <button type="submit" class="delete-all-btn">Notīrīt paziņojumus</button>
                </form>
            </div>

            @forelse(auth()->user()->notifications as $notification)
                <div class="notification">
                    <div class="notification-title">
                        <strong>{{ $notification->data['student_name'] ?? 'Nezināms students' }}</strong>
                    </div>
                    <small>Konsultācija: {{ \Carbon\Carbon::parse($notification->data['consultation_date'])->format('d.m.Y H:i') }}</small><br>
                    <small>Iemesls: {{ $notification->data['reason'] ?? 'Nav norādīts iemesls' }}</small>
                </div>
            @empty
                <div class="no-notifications">Nav jaunu paziņojumu.</div>
            @endforelse
        </div>
    </div>
</body>
</html>
