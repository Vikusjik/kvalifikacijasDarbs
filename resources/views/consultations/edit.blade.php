<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rediģēt konsultāciju</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8fb;
            background-image: url('{{ asset('images/VT-eka.png') }}');
            background-size: 40%;
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
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            margin-bottom: 25px;
            color: #356b8c;
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
            color: #444;
        }

        input[type="datetime-local"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 25px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .submit-btn {
            padding: 14px 28px;
            background-color: #4a90e2;
            color: white;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #357ab8;
        }

        .back-btn {
            background-color: #d3e0ea;
            color: #333;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #c0d3df;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Rediģēt konsultāciju</h1>

        <form method="POST" action="{{ route('consultations.update', $consultation->id) }}">
            @csrf
            @method('PUT')

            <label for="date_time">Konsultācijas datums un laiks:</label>
            <input type="datetime-local" id="date_time" name="date_time"
                   value="{{ \Carbon\Carbon::parse($consultation->date_time)->format('Y-m-d\TH:i') }}"
                   required>

            <div class="button-container">
                <button type="submit" class="submit-btn">Atjaunināt</button>
                <a href="{{ route('consultations.index') }}" class="back-btn">Atpakaļ uz sarakstu</a>
            </div>
        </form>
    </div>

</body>
</html>
