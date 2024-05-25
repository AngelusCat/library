<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу в библиотеку</title>
    {{--TODO: Вынести css в отдельный файл--}}
    {{--TODO: Стилизовать кнопку "+" по своему усмотрению--}}
    <style>
        .add
        {
            width: 75px;
            height: 75px;
            line-height: 75px;
            text-align: center;
            border: 1px dashed grey;
            margin: 10px 0;
        }

        .add:hover
        {
            cursor: pointer;
            background-color: #360581;
        }
    </style>
</head>
<body>
    {{--TODO: Сделать корректное значение для атрибута name у всех input, связанных с ФИО автора--}}
    {{--TODO: Сделать label для input--}}
    {{--TODO: Сделать корректные значения для атрибута placeholder--}}
    {{--TODO: Написать правила валидации всех полей--}}
    {{--TODO: Выбрать корректные атрибуты для полей input, label, div, textarea--}}
    <form method="POST" action="/books">
        @csrf
        <input type="text" name="title" placeholder="Название книги">
        <input type="text" name="author0" placeholder="ФИО автора">
        <div id="input1"></div>
        {{--TODO: Позиционировать элементы так, чтобы кнопка "+" была справа от поля ФИО автора--}}
        <div class="add" onclick="addInput()">+</div>
        <textarea name="description" placeholder="Описание книги"></textarea>
        <input type="number" name="yearOfPublication" placeholder="Год публикации">
        <input type="submit" value="Добавить">
    </form>
    {{--TODO: Вынести JS в отдельный файл--}}
    <script>
        let x = 1;

        function addInput() {
            //if (x < 10) {
            const str = '<input type="text" name="author' + x + '" placeholder="ФИО автора"> <div id="input' + (x + 1) + '"></div>';
            document.getElementById('input' + x).innerHTML = str;
            x++;
            //} else
            //{
            //    alert('STOP it!');
            //}
        }
    </script>
</body>
</html>
