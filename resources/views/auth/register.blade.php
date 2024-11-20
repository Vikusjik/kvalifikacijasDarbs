<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reģistrācija</title>
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
                <img src="{{ asset('VT-logo.jpeg') }}" alt="VT Logo" class="logo">
            </div>

            <!-- Informācija par reģistrēšanos -->
            <div class="text-description">
                {{ __('Lūdzu, aizpildiet formu, lai izveidotu jaunu kontu.') }}
            </div>

            <!-- Validācijas kļūdas -->
            <x-validation-errors class="mb-4" />

            <!-- Forma -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-control">
                    <label for="name">{{ __('Vārds un Uzvārds') }}</label>
                    <input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="form-control">
                    <label for="email">{{ __('E-pasts') }}</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>

                <div class="form-control">
                    <label for="password">{{ __('Parole') }}</label>
                    <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="form-control">
                    <label for="password_confirmation">{{ __('Paroles apstiprināšana') }}</label>
                    <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="form-control">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2">
                                {!! __('Piekrītu :terms_of_service un :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Esi jau reģistrēts?') }}
                    </a>

                    <button type="submit" class="btn ms-4">
                        {{ __('Iereģistrēties') }}
                    </button>
                </div>
            </form>
        </div>
    </x-guest-layout>
</body>
</html>
