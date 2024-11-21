<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aizmirsta parole</title>
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
            margin-bottom: 30px; /* Atstarpe zem logotipa */
        }

        .logo {
            max-width: 120px; /* Logotipa izmērs */
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

        .text-description {
            margin-bottom: 20px;
            color: #555;
            font-size: 14px;
            line-height: 1.5;
        }

        .status-message {
            font-size: 14px;
            color: #28a745;
            margin-bottom: 20px;
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

            <!-- Informācija par paroles atiestatīšanu -->
            <div class="text-description">
                {{ __('Aizmirsi paroli? Ieraksti e-pastu un izveido jaunu paroli!') }}
            </div>

            <!-- Statusa ziņojums -->
            @session('status')
                <div class="status-message">
                    {{ $value }}
                </div>
            @endsession

            <!-- Validācijas kļūdas -->
            <x-validation-errors class="mb-4" />

            <!-- Forma -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-control">
                    <label for="email">{{ __('E-pasts') }}</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                </div>

                <div class="form-control">
                    <button type="submit" class="btn">
                        {{ __('E-pasta paroles atiestatīšanas saite') }}
                    </button>
                </div>
            </form>
        </div>
    </x-guest-layout>
</body>
</html>
