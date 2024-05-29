<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $book->title }}</title>
</head>
<body>
    <p><i><b>Название книги</b></i>: {{ $book->title }}</p>
    <h2 align="center"><i><b>Список авторов</b></i></h2>
    <hr>
    @foreach($book->authors as $author)
        <p>{{ $loop->iteration }}) <i><b>ФИО автора</b></i>: {{ $author->full_name }}, <i><b>ID автора</b></i>: {{ $author->id }}</p>
    @endforeach
    <textarea placeholder="Описание книги">{{ $book->description ?? '' }}</textarea>
    <p><i><b>Год публикации</b></i>: {{ $book->year_of_publication }}</p>
</body>
</html>
