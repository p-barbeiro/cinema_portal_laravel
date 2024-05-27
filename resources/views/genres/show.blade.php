<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Course</title>
</head>
<body>
<h2>Course "{{ $genre->name }}"</h2>
<div>
    @include('genres.shared.fields', ['readonlyData' => true])
</div>
</body>
</html>
