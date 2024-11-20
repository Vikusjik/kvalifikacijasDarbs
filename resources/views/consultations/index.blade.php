<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultācijas</title>
</head>
<body>
    <h1>Konsultācijas</h1>

    @if(Auth::check() && Auth::user()->usertype == 'admin')
        <a href="{{ route('consultations.create') }}">Uztaisīt konsultāciju</a>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultations as $consultation)
                <tr>
                    <td>{{ $consultation->id }}</td>
                    <td>{{ $consultation->title }}</td>
                    <td>
                        @if(Auth::check() && Auth::user()->usertype == 'admin')
                            <a href="{{ route('consultations.edit', $consultation->id) }}">Edit</a>
                            <form action="{{ route('consultations.destroy', $consultation->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Vai esat pārliecināts?')">Dzēst</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
