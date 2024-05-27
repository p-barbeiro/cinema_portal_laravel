<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Genre</title>
</head>
<body>
<h2>Update Genre "{{ $genre->name }}"</h2>

<form method="POST" action="{{ route('genres.update', ['genre' => $genre]) }}">
    @csrf
    @method('PUT')
    @include('genres.shared.fields')
    <div>
        <button type="submit" name="ok">Save genre</button>
    </div>
</form>
</body>
</html>
