<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Изменить информацию о книге</title>
</head>
<body>

<h1>Изменить информацию о книге</h1><br>

<form method="POST" action="/editBook">
    @method('PATCH')
    @include('incs.startBookForm')

    <hr>
    <sup>
    <pre style="font-size: 150%">
        Если Вы ошиблись при написании ФИО автора, то Вы можете обернуть ФИО этого автора скобками, а слева от скобок, оставив один пробел,
        вписать правильную версию ФИО.
                    <b>Пример</b>:
        <b>Было так</b>: Дастоевский Федор Михайлович
        <b>Стало так</b>: Достоевский Федор Михайлович (Дастоевский Федор Михайлович)

        <b>!!!Важно!!!</b> Это поле только для изменения ФИО автора, если Вы хотите добавить или удалить автора, то воспользуйтесь двумя нижними полями.
        Если Вы хотите добавить автора, то его ФИО нужно писать только в поле для добавления автора, но не сюда.
        Если Вы хотите удалить автора, то его ФИО нужно вписать в поле для удаления автора, а отсюда не стирать.
    </pre>
    </sup>

    @error('originalOrModifiedAuthors')
    <div style="color: #ef4444">{{ $message }}</div><br>
    @enderror

    <label for="originalOrModifiedAuthors">ФИО авторов, связанных с книгой: </label>
    <input type="text" name="originalOrModifiedAuthors" id="originalOrModifiedAuthors" size="100" value="{{ (old('originalOrModifiedAuthor') !== null) ? old('originalOrModifiedAuthor') : (isset($authors) ? $authors : '') }}"><br><br>

    <hr>
    <sup>
    <pre style="font-size: 150%">
        Если при создании книги Вы забыли упомянуть определенного автора, то Вы можете вписать его ФИО сюда.
        Если авторов несколько, то следует разделить их запятой.
        <b>Пример</b>: Иванов Иван Иванович, Петров Петр Петрович
    </pre>
    </sup>

    @error('newAuthors')
    <div style="color: #ef4444">{{ $message }}</div><br>
    @enderror

    <label for="newAuthors">ФИО автора(ов), которого нужно добавить к книге: </label>
    <input type="text" name="newAuthors" id="newAuthors" size="100" placeholder="ФИО автора(ов), которого нужно добавить к книге" value="{{ (old('newAuthors') !== null) ? old('newAuthors') : '' }}"><br><br>

    <hr>
    <sup>
    <pre style="font-size: 150%">
        Если при создании книги Вы ошиблись и вписали не того автора
        (к примеру, Вы думали, что "Записки охотника" написал Достоевский Федор Михайлович, а оказалось, что Тургенев Иван Сергеевич), то Вы можете вписать его ФИО сюда.
        Если авторов несколько, то следует разделить их запятой.
        <b>Пример</b>: Иванов Иван Иванович, Петров Петр Петрович
    </pre>
    </sup>

    @error('deletedAuthors')
    <div style="color: #ef4444">{{ $message }}</div><br>
    @enderror

    <label for="deletedAuthors">ФИО автора(ов), которого нужно удалить у книги: </label>
    <input type="text" name="deletedAuthors" id="deletedAuthors" size="100" placeholder="ФИО автора(ов), которого нужно удалить у книги" value="{{ (old('deletedAuthors') !== null) ? old('deletedAuthors') : '' }}"><br><br>
    <hr>

    @include('incs.endBookForm')

    <input type="submit" value="Изменить">

</form>
</body>
</html>
