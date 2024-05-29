<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $author->full_name }}</title>
</head>
<body>
    <p>ФИО автора: {{ $author->full_name }}</p>
    <p>Список книг: </p>
    <hr>
    @foreach($author->books as $book)
        <p>Книга №{{ $loop->iteration }}</p>
        <p>ID книги: {{ $book->id }}</p>
        <p>Название книги: {{ $book->title }}</p>
        <p>Год публикации: {{ $book->year_of_publication }}</p>
        <hr>
    @endforeach
    <p>Количество написанных автором книг, находящихся в библиотеке: {{ $numberOfBooksWritten }}</p>
</body>
</html>
