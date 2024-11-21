<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ventspils Tehnikums 2</title>
    <style>
        /* Kopējie stili */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .auth-card {
            max-width: 500px;
            width: 90%;
            padding: 30px;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 30px; /* Lielāka atstarpe zem logotipa */
        }

        .logo {
            max-width: 120px; /* Lielāks logotips */
            height: auto;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .form-control {
            margin: 15px 0;
            text-align: left;
        }

        .form-control label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .form-control input {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .checkbox-container input[type="checkbox"] {
            width: 16px;
            height: 16px; /* Mazāks kvadrāts */
            margin-right: 10px;
        }

    </style>
</head>
<body>
    <x-guest-layout>
        <div class="auth-card">
            <!-- Logotips -->
            <div class="logo-container">
                <img src="{{ asset('images/VT-logo.jpeg') }}" alt="VT Logo" class="logo">
            </div>

            <!-- Validācijas kļūdas -->
            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Pieteikšanās forma -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-control">
                    <label for="email">{{ __('E-pasts') }}</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                </div>

                <div class="form-control">
                    <label for="password">{{ __('Parole') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me" class="text-sm text-gray-600">{{ __('Atcerēties mani') }}</label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Aizmirsi paroli?') }}
                        </a>
                    @endif

                    <button type="submit" class="btn">
                        {{ __('Pieslēgties') }}
                    </button>
                </div>
            </form>
        </div>
    </x-guest-layout>
</body>
</html>
