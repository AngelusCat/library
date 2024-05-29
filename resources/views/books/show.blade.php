<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $book->title }}</title>
</head>
<body>
    <p>Название книги: {{ $book->title }}</p>
    <p>Список авторов: </p>
    @foreach($book->authors as $author)
        <p>{{ $loop->iteration }}) ФИО автора: {{ $author->full_name }}, ID автора: {{ $author->id }}</p>
    @endforeach
    <textarea placeholder="Описание книги">{{ $book->description ?? '' }}</textarea>
    <p>Год публикации: {{ $book->year_of_publication }}</p>
</body>
</html>
