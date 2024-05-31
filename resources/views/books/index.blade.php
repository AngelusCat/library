<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список книг</title>
    @vite(['resources/js/books/index.js'])
</head>
<body>
    @include('incs.navbar')
    <h1>Список книг</h1>
    <button data-type="create" style="position: fixed; left: 80%;">Добавить новую книгу в библиотеку</button><br><br>
    <hr>
    @foreach($listOfBooks as $book)
        <p><i><b>Название книги</b></i>: {{ $book->title }}</p>
        <p><i><b>Год публикации</b></i>: {{ $book->year_of_publication }}</p>
        <p><i><b>Один из авторов</b></i>: {{ $book->authors()->first()->full_name ?? '' }}</p>
        <button data-type="show" data-id="{{ $book->id }}">Показать полную информацию о книге</button>
        <button data-type="edit" data-id="{{ $book->id }}">Изменить информацию о книге</button>
        <button data-type="delete" data-id="{{ $book->id }}">Удалить книгу</button>
        <br>
        <hr>
    @endforeach
</body>
</html>
