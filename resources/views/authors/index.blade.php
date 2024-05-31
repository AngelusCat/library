<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список авторов</title>
    @vite(['resources/js/authors/index.js'])
</head>
<body>
    @include('incs.navbar')
    <h1>Список авторов</h1><br>
    <hr>
    @foreach($listOfAuthors as $author)
        <p><i><b>ФИО автора</b></i>: {{ $author->full_name }}</p>
        <button data-type="showAuthor" data-id="{{ $author->id }}">Показать полную информацию об авторе</button>
        <hr>
    @endforeach
</body>
</html>
