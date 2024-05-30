<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу в библиотеку</title>
</head>
<body>

<h1>Добавить книгу в библиотеку</h1><br>

<form method="POST" action="/addBook">
    @include('incs.startBookForm')

    <sup>
    <pre style="font-size: 150%">
Фамилию, имя и отчество пишите <b>с заглавной буквы</b>, оставляя между ними <b>один пробел</b>.
Если авторов больше одного, то <b>используйте запятую</b>, чтобы их разделить.
<b>Пример</b>: Иванов Иван Иванович, Петров Петр Петрович
<b>Ставить точку в конец предложения не нужно</b>.
    </pre>
    </sup>

    <label for="authors">ФИО автора(ов) книги</label>
    <input type="text" name="authors" id="authors" placeholder="ФИО автора(ов) книги" value="{{ isset($authors) ? $authors : '' }}" size="97" required><br><br>

    @include('incs.endBookForm')

    <input type="submit" value="Добавить">
</form>


</body>
</html>
