<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rediģēt konsultāciju</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f2ff;
            background-image: url('{{ asset('images/VT-eka.png') }}');
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

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin: 0 auto;
            text-align: left;
            max-width: 500px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        input[type="datetime-local"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s ease-in-out;
            margin-right: 10px;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        /* Stils pogai 'Atpakaļ uz sarakstu' */
        .back-btn {
            background-color: #28a745;
            padding: 12px 25px;
            color: white;
            border-radius: 30px;
            text-transform: uppercase;
            font-weight: 600;
            border: 2px solid transparent;
            transition: all 0.3s ease-in-out;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .back-btn:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-3px);
        }

        .back-btn i {
            font-size: 18px;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Rediģēt konsultāciju</h1>

        <form method="POST" action="{{ route('consultations.update', $consultation->id) }}">
            @csrf
            @method('PUT')

            <!-- Date and Time -->
            <label for="date_time">Konsultācijas datums un laiks:</label>
            <input type="datetime-local" id="date_time" name="date_time" value="{{ \Carbon\Carbon::parse($consultation->date_time)->format('Y-m-d\TH:i') }}" required>

            <div class="button-container">
                <button type="submit">Atjaunināt</button>
                <a href="{{ route('consultations.index') }}" class="back-btn">
                    <i class="fa fa-arrow-left"></i> Atpakaļ uz sarakstu
                </a>
            </div>
        </form>
    </div>

</body>
</html>
