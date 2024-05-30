@csrf
@error('title')
    <div style="color: #ef4444">{{ $message }}</div><br>
@enderror
<label for="title">Название книги: </label>
<input type="text" name="title" id="title" placeholder="Название книги" value="{{ (old('title') !== null) ? old('title') : (isset($book) ? $book->title : '') }}" minlength="1" maxlength="120" size="50" required><br><br>
