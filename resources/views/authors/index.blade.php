<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список авторов</title>
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

    <script>
        let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000`;

        let showAuthorsButtons = document.querySelectorAll('[data-type="showAuthor"]');
        showAuthorsButtons.forEach(function (elem) {
            elem.onclick = function () {
                let id = elem.getAttribute('data-id');
                window.open('http://library/showAuthor/' + id, 'showAuthor', params);
            }
        });
    </script>
</body>
</html>
