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
            background-image: url('VT-eka.png');
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

        .logo-container {
            margin-bottom: 20px;
        }
        .logo {
            max-width: 120px;
            height: auto;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
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
            margin-top: 20px;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Logotips -->
        <div class="logo-container">
            <img src="/VT-logo.jpeg" alt="Ventspils Tehnikums Logo" class="logo">
        </div>

        <!-- Skolotāju lapa -->
        <h1>Skolotāju lapa</h1>

        <!-- Navigācija -->
        <nav>
            <a href="{{ route('consultations.create') }}">Pievienot konsultāciju</a>
            <a href="{{ route('consultations.index') }}">Rediģēt konsultāciju</a>
            <a href="{{ route('consultations.index') }}">Dzēst konsultāciju</a>
        </nav>

        <!-- Logout poga -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <input type="submit" value="Izrakstīties">
        </form>
    </div>
</body>
</html>
