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
            <a href="{{ route('myConsultation.index') }}">Manas konsultācijas</a>
        </nav>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <input type="submit" value="Izrakstīties">
        </form>
    </div>
</body>
</html>
