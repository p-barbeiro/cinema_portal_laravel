<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>genres</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<h1>List of genres</h1>
<p><a href="{{ route('genres.create') }}">Create a new genre</a></p>
<table>
    <thead>
    <tr>
        <th>Abbreviation</th>
        <th>Name</th>
        <th>Custom</th>
        <th>Deleted At</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($genres as $genre)
        <tr>
            <td>{{ $genre->code }}</td>
            <td>{{ $genre->name }}</td>
            <td>{{ $genre->custom }}</td>
            <td>{{ $genre->deleted_at }}</td>
            <td>
                <a href="{{ route('genres.show', ['genre' => $genre]) }}">View</a>
            </td>
            <td>
                <a href="{{ route('genres.edit', ['genre' => $genre]) }}">Update</a>
            </td>
            <td>
                <form method="POST"
                      action="{{ route('genres.destroy', ['genre' => $genre]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
