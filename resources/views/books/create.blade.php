<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу в библиотеку</title>
</head>
<body>
{{--TODO: Сделать корректное значение для атрибута name у всех input, связанных с ФИО автора--}}
{{--TODO: Сделать label для input--}}
{{--TODO: Сделать корректные значения для атрибута placeholder--}}
{{--TODO: Написать правила валидации всех полей--}}
{{--TODO: Выбрать корректные атрибуты для полей input, label, div, textarea--}}
<form method="POST" action="/addBook">
    @include('incs.startBookForm')
    <input type="text" name="authors" placeholder="ФИО автора(ов) книги" value="{{ isset($authors) ? $authors : '' }}">
    @include('incs.endBookForm')
</form>


</body>
</html>
