<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\LibraryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function __construct(private readonly LibraryService $libraryService) {}

    public function showFormToAddBook(): View
    {
        return view('books.create');
    }

    public function addBook(StoreBookRequest $request): void
    {
        $this->libraryService->addBook($request);
    }

    public function showFormToEditBook(int $bookId): View
    {
        $book = Book::find($bookId);

        $authors = array_map(function ($author) {
            return $author->full_name;
        }, $book->authors->all());

        return view('books.edit', [
            'book' => $book,
            'authors' => count($authors) > 0 ? implode(', ', $authors) : $book->authors->full_name
        ]);
    }

    public function editBook(UpdateBookRequest $request): void
    {
        $this->libraryService->editBook($request);
    }

    public function getRidOfBook(int $id)
    {
        $this->libraryService->destroyInventoryOfSpecificBook($id);
    }

    public function getListOfBooks()
    {
        $this->libraryService->getListOfAllBooks();
    }

    public function getListOfAuthors()
    {
        $this->libraryService->getListOfAllAuthors();
    }

    public function getCompleteInformationAboutBook()
    {

    }

    public function getCompleteInformationAboutAuthor()
    {

    }
}
