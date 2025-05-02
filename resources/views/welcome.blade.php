<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Viktorijas Tehnikums - Mājaslapa</title>
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
    
        .btn {
            padding: 10px 20px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
            border: none;
        }
    
        .btn:hover {
            background-color: #357ab8;
        }
    </style>
    
</head>
<body>
    <!-- Konteiners apakšā ar logotipu un pogām -->
    <div class="container">
        <!-- Logotips -->
        <div class="logo-container">
            <img src="images/VT-logo.jpeg" alt="Ventspils Tehnikums Logo" class="logo">
        </div>

        <!-- Navigācija -->
        @if (Route::has('login'))
    <nav>
        @auth
            <!-- Ja lietotājs ir parasts lietotājs, parādi "Dashboard" -->
            @if (Auth::user()->usertype == 'user') <!-- Piemērs ar lomu "user" -->
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @endif
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
