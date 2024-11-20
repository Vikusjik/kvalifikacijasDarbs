<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pievienot konsultaciju</title>
</head>
<body>
  

        <form action="{{ route('consultations.store') }}" method="POST">
            @csrf
            <label for="title">Konsultacijas tēma:</label>
            <input type="text" id="title" name="title" required>
            <button type="submit" value="Create">Saglabāt</button>
        </form>
        

</body>
</html>