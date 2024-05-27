@csrf
<input type="text" name="title" placeholder="Название книги" value="{{ isset($book) ? $book->title : '' }}">
<input type="text" name="authors" placeholder="ФИО автора(ов) книги" value="{{ isset($authors) ? $authors : '' }}">
<textarea cols="100" rows="5" name="description" placeholder="Описание книги">{{ isset($book) ? $book->description : '' }}</textarea>
<input type="number" name="year_of_publication" placeholder="Год публикации" value="{{ isset($book) ? $book->year_of_publication : '' }}">
<input type="submit" value="Добавить">
