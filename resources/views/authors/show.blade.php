<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $author->full_name }}</title>
</head>
<body>
    <p><i><b>ФИО автора</b></i>: {{ $author->full_name }}</p>
    <h2 align="center"><i>Список книг</i></h2>
    <hr>
    @foreach($author->books as $book)
        <h3 align="center"><i>Книга</i> №{{ $loop->iteration }}</h3>
        <p><i><b>ID книги</b></i>: {{ $book->id }}</p>
        <p><i><b>Название книги</b></i>: {{ $book->title }}</p>
        <p><i><b>Год публикации</b></i>: {{ $book->year_of_publication }}</p>
        <hr>
    @endforeach
    <p><i><b>Количество книг автора, находящихся в библиотеке</b></i>: </p><p id="numberOfBooks">{{ $numberOfBooksWritten }}</p>
    <button id="updateNumberOfBooks" data-id="{{ $author->id }}">Обновить количество книг</button>
    <script>
        let numberOfBooks = document.getElementById('numberOfBooks');
        let updateNumberOfBooksButton = document.getElementById('updateNumberOfBooks');
        let id = updateNumberOfBooksButton.getAttribute('data-id');
        updateNumberOfBooksButton.addEventListener('click', function () {
            let promise = fetch('/test/' + id).then(function (response) {
                response.text().then(function (text) {
                    numberOfBooks.textContent = text;
                });
            });
        });
    </script>
</body>
</html>
