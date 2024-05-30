<label for="description">Описание книги: </label>
<textarea cols="100" rows="5" name="description" id="description" placeholder="Описание книги">{{ isset($book) ? $book->description : '' }}</textarea><br><br>
<label for="year_of_publication">Год публикации: </label>
<input type="number" name="year_of_publication" id="year_of_publication" placeholder="Год публикации" value="{{ isset($book) ? $book->year_of_publication : '' }}" min="-600" max="{{ date('Y') }}" minlength="4" maxlength="4" required><br><br>
