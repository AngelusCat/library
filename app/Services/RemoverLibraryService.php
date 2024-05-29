<?php

namespace App\Services;

use App\Models\Book;

class RemoverLibraryService
{
    public function deleteBook(int $bookId): void
    {
        $book = Book::find($bookId);
        dump($book);
    }
}
