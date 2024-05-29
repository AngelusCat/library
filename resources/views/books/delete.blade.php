<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Удалить книгу</title>
</head>
<body>
    <form action="{{ route('deleteBook', ['id' => $book->id]) }}">
        @method('DELETE')
        @csrf
        <input type="submit" value="Удалить книгу">
    </form>
</body>
</html>
