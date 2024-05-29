<?php

namespace App\Services;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;

class LibraryService
{
    public function __construct
    (
        private readonly CreatorLibraryService $creator,
        private readonly ChangerLibraryService $changer,
        private readonly RemoverLibraryService $remover,
        private readonly FinderLibraryService  $finder
    ){}

    public function addBook(StoreBookRequest $request): void
    {
        $this->creator->addBook($request);
    }

    public function editBook(UpdateBookRequest $request): void
    {
        $this->changer->editBook($request);
    }

    public function deleteBook(int $bookId): void
    {
        $this->remover->deleteBook($bookId);
    }

    public function getListOfBooks(): array
    {
        return $this->finder->getListOfBooks();
    }

    public function getFullInformationAboutBook(int $bookId): Book
    {
        return $this->finder->getFullInformationAboutBook($bookId);
    }

    public function getListOfAuthors(): array
    {
        return $this->finder->getListOfAuthors();
    }

    public function getFullInformationAboutAuthor(int $authorId): Author
    {
        return $this->finder->getFullInformationAboutAuthor($authorId);
    }
}
