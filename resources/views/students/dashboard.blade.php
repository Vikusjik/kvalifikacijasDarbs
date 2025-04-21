<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Skolēnu lapa</title>
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
            justify-content: flex-end;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Skolēnu lapa</h1>
        </div>

        <!-- Navigācija -->
        <nav>
            <a href="{{ route('consultations.index') }}">Konsultāciju saraksts</a>
            <a href="{{ route('myConsultation.index') }}">Pieteiktās konsultācijas</a>
        </nav>

        <!-- Notifications -->
        <div class="notifications">
            <h3>Jūsu paziņojumi</h3>

            <div class="clear-btn">
                <form method="POST" action="{{ route('notifications.clear') }}">
                    @csrf
                    <button type="submit">Notīrīt paziņojumus</button>
                </form>
            </div>

            @forelse($notifications as $notification)
                <div class="notification">
                    {{ $notification->data['message'] }}
                </div>
            @empty
                <p>Nav jaunu paziņojumu.</p>
            @endforelse
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <input type="submit" value="Izrakstīties">
        </form>
    </div>
</body>
</html>
