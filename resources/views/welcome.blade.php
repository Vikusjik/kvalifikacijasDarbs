<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ventspils Tehnikums - Mājaslapa</title>
    <style>
        /* Kopējie stili */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4fc; /* Rezerves fona krāsa */
            background-image: url('VT-eka.jpg'); /* Fona attēls */
            background-size: cover; /* Pārklāj visu lapu */
            background-position: center; /* Centrs */
            background-repeat: no-repeat; /* Attēlu neatkārto */
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: flex-end; /* Novieto saturu apakšā */
        }

        /* Konteiners apakšā */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Puscaurspīdīgs balts fons, lai saturs būtu vieglāk lasāms */
            border-radius: 10px;
            position: fixed;
            bottom: 0; /* Novieto pie apakšas */
            left: 50%;
            transform: translateX(-50%); /* Centrs horizontāli */
            width: 100%; /* Aizņem visu platumu */
            box-sizing: border-box;
        }

        /* Logo un galvenes stili */
        .logo-container {
            text-align: center;
            margin-bottom: 10px; /* Samazina atstarpi ap logotipu */
        }
        .logo {
            max-width: 150px;
            height: auto;
        }

        /* Navigācijas joslas stili */
        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }
        nav a {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        nav a:hover {
            background-color: #4c9ed9;
            color: white;
        }

        /* Pogu stili */
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Konteiners apakšā ar logotipu un pogām -->
    <div class="container">
        <!-- Logotips -->
        <div class="logo-container">
            <img src="/VT-logo.png" alt="Ventspils Tehnikums Logo" class="logo">
        </div>

        <!-- Navigācija -->
        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Pieslēgties</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn">Reģistrēties</a>
                    @endif
                @endauth
            </nav>
        @endif
    </div>
</body>
</html>
