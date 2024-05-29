<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список книг</title>
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
    <script>
        let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000`;

        let createButton = document.querySelector('[data-type="create"]');
        createButton.onclick = function () {
            window.open('http://library/addBook', 'create', params);
        }

        let editButtons = document.querySelectorAll('[data-type="edit"]');
        editButtons.forEach(function (elem) {
            elem.onclick = function () {
                let id = elem.getAttribute('data-id');
                window.open('http://library/editBook/' + id, 'edit', params);
            }
        });

        let deleteButtons = document.querySelectorAll('[data-type="delete"]');
        deleteButtons.forEach(function (elem) {
            elem.onclick = function () {
                let id = elem.getAttribute('data-id');
                window.open('http://library/deleteBook/' + id, 'delete', params);
            }
        });

        let showButtons = document.querySelectorAll('[data-type="show"]');
        showButtons.forEach(function (elem) {
            elem.onclick = function () {
                let id = elem.getAttribute('data-id');
                window.open('http://library/showBook/' + id, 'show', params);
            }
        });
    </script>
</body>
</html>
