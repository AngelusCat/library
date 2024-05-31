<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;

class FinderLibraryService
{
    public function getListOfBooks(): array
    {
        return Book::all()->all();
    }

    public function getFullInformationAboutBook(int $bookId): Book
    {
        return Book::find($bookId);
    }

    public function getListOfAuthors(): array
    {
        $result = [];
        $books = Book::all()->all();

        foreach ($books as $book) {
            $authors = $book->authors->all();
            foreach ($authors as $author) {
                $result[] = $author;
            }
        }

        return collect($result)->unique('full_name')->all();
    }

    public function getFullInformationAboutAuthor(int $authorId): Author
    {
        return Author::find($authorId);
    }
}
