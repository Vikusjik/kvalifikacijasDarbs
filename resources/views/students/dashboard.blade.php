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

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .logout-form {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .logout-form input {
            background-color: #d9534f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .logout-form input:hover {
            background-color: #c9302c;
        }

        .content-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .button-container {
            margin-top: 20px;
        }

        .button-container a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .button-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Skolēnu lapa</h1>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Skolēnu lapa') }}
        </h2>
        
        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <input type="submit" value="Izrakstīties">
        </form>

    

            <!-- Konsultāciju saraksta poga -->
            <div class="button-container">
                <a href="{{ route('consultations.index') }}">Konsultāciju saraksts</a>
                <a href="{{ route('myConsultation.index') }}" class="btn">Manas konsultācijas</a>
            </div>
        </div>
    </div>
</body>
</html>
