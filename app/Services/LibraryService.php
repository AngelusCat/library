<?php

namespace App\Services;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

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
}
