<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form method="POST" action="{{ route('consultations.update', $consultation->id) }}">
        @csrf
        @method('PUT')
        <label for="title">Consultation Title:</label>
        <input type="text" id="title" name="title" value="{{ $consultation->title }}" required>
        <button type="submit">Update</button>
    </form>
    
    
</body>
</html>