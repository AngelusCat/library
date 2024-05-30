
<label for="description">Описание книги: </label>
<textarea cols="100" rows="5" name="description" id="description" placeholder="Описание книги">{{ (old('description') !== null) ? old('description') : (isset($book) ? $book->description : '') }}</textarea><br><br>

@error('year_of_publication')
<div style="color: #ef4444">{{ $message }}</div><br>
@enderror
<label for="year_of_publication">Год публикации: </label>
<input type="number" name="year_of_publication" id="year_of_publication" placeholder="Год публикации" value="{{ (old('year_of_publication') !== null) ? old('year_of_publication') : (isset($book) ? $book->year_of_publication : '') }}" min="-500" max="{{ date('Y') }}" minlength="4" maxlength="4" required><br><br>
