@csrf
<label for="title">Название книги: </label>
<input type="text" name="title" id="title" placeholder="Название книги" value="{{ isset($book) ? $book->title : '' }}" minlength="1" maxlength="120" size="50" required><br><br>
