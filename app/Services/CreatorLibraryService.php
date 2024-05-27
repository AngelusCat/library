<?php

namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\AuthorBook;
use App\Models\Book;

class CreatorLibraryService
{
    public function addBook(BookRequest $request): void
    {
        $data = $request->all();

        $book = new Book();
        $book->title = $data['title'];
        if ($data['description'] !== null) {
            $book->description = $data['description'];
        }
        $book->year_of_publication = $data['yearOfPublication'];
        $book->save();

        $bookId = $book->id;

        $authors = $this->getListOfAuthors($data['authors']);

        $authorsIds = $this->saveAuthorsAndGetId($authors);

        $this->saveConnectionsBookAuthors($bookId, $authorsIds);

    }

    private function getListOfAuthors(string $authorsLine): array
    {
        $authorsArray = explode(',', $authorsLine);
        return array_map(function (string $author) {
            return trim($author);
        }, $authorsArray);
    }

    private function authorIsInAuthorsTable(string $fullName): bool
    {
        $check = Author::query()->where('full_name', '=', $fullName)->count();
        return $check === 1;
    }

    private function saveAuthorsAndGetId(array $authors): array
    {
        return array_map(function (string $authorFullName) {

            $check = $this->authorIsInAuthorsTable($authorFullName);

            if ($check) {
                return Author::query()->where('full_name', '=', $authorFullName)->get('id');
            } else {
                $author = new Author();
                $author->full_name = $authorFullName;
                $author->save();
                return $author->id;
            }
        }, $authors);
    }

    private function saveConnectionsBookAuthors(int $bookId, array $authorsIds): void
    {
        foreach ($authorsIds as $authorId) {
            $authorBookTable = new AuthorBook();
            $authorBookTable->author_id = $authorId;
            $authorBookTable->book_id = $bookId;
            $authorBookTable->save();
        }
    }

}
