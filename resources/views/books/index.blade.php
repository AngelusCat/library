<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список книг</title>
</head>
<body>
    <h1>Список книг</h1>
    <button data-type="create" style="position: fixed; left: 80%;">Добавить новую книгу в библиотеку</button><br><br>
    <hr>
    @foreach($listOfBooks as $book)
        <p>Название книги: {{ $book->title }}</p>
        <p>Год публикации: {{ $book->year_of_publication }}</p>
        <p>Один из авторов: {{ $book->authors()->first()->full_name }}</p>
        <button data-type="show" data-id="{{ $book->id }}">Показать полную информацию о книге</button>
        <button data-type="edit" data-id="{{ $book->id }}">Изменить информацию о книге</button>
        <button data-type="delete" data-id="{{ $book->id }}">Удалить книгу</button>
        <br>
        <hr>
    @endforeach
    <script>
        let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000`;

        let createButton = document.querySelector('[data-type="create"]');
        createButton.onclick = function () {
            window.open('http://library/addBook', 'test', params);
        }

        let editButtons = document.querySelectorAll('[data-type="edit"]');
        editButtons.forEach(function (elem) {
            elem.onclick = function () {
                let id = elem.getAttribute('data-id');
                window.open('http://library/editBook/' + id, 'test2', params);
            }
        });

        let deleteButtons = document.querySelectorAll('[data-type="delete"]');
        deleteButtons.forEach(function (elem) {
            elem.onclick = function () {
                let id = elem.getAttribute('data-id');
                window.open('http://library/deleteBook/' + id, 'test3', params);
            }
        });

        let showButtons = document.querySelectorAll('[data-type="show"]');
        showButtons.forEach(function (elem) {
            elem.onclick = function () {
                let id = elem.getAttribute('data-id');
                window.open('http://library/showBook/' + id, 'test4', params);
            }
        });
    </script>
</body>
</html>
