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
                $fullName = $author->full_name;
                if (in_array($fullName, $result)) {
                    continue;
                }
                $result[] = $author;
            }
        }
        return $result;
    }

    public function getFullInformationAboutAuthor(int $authorId): Author
    {
        return Author::find($authorId);
    }
}
