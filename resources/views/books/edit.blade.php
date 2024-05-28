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
<form method="POST" action="/editBook">
    @method('PATCH')
    @include('incs.startBookForm')
    <label>
        <input type="text" name="originalOrModifiedAuthors" size="100"
               value="{{ isset($authors) ? $authors : '' }}"><br><br>
        Если Вы хотите изменить ФИО конкретного автора, то оберните его ФИО скобками, а слева от него напишите новый
        вариант ФИО. Пример: Иванов Иван Иванович -> Петров Иван Иванович (Иванов Иван Иванович)</label><br><br>
    <label><input type="text" name="newAuthors" size="100">Если Вы хотите добавить нового автора к этой книге, то
        напишите его ФИО сюда (для нескольких авторов разделяйте их ФИО запятой)</label><br><br>
    <label><input type="text" name="deletedAuthors" size="100">Если Вы хотите удалить у книги конкретного автора, то
        впишите его ФИО сюда (для нескольких авторов разделяйте их ФИО запятой)</label><br><br>
    @include('incs.endBookForm')
</form>
</body>
</html>
