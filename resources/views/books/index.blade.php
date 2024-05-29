<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список книг</title>
</head>
<body>
    @foreach($listOfBooks as $book)
        <p>Название книги: {{ $book->title }}</p>
        <p>Год публикации: {{ $book->year_of_publication }}</p>
        <p>Один из авторов: {{ $book->authors()->first()->full_name }}</p>
        <br>
    @endforeach
</body>
</html>
