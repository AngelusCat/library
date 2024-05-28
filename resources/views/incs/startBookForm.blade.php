@csrf
<input type="text" name="title" placeholder="Название книги" value="{{ isset($book) ? $book->title : '' }}">
