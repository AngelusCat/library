<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Удалить книгу</title>
</head>
<body>
    <form action="{{ route('deleteBook', ['book_id' => $bookId]) }}" method="POST">
        @method('DELETE')
        @csrf
        <input type="submit" value="Удалить книгу">
    </form>
</body>
</html>
