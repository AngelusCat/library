<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\LibraryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function __construct(private readonly LibraryService $libraryService) {}

    public function showListOfBooks(): View
    {
        $listOfBooks = $this->libraryService->getListOfBooks();
        return view('books.index', ['listOfBooks' => $listOfBooks]);
    }

    public function showFormToAddBook(): View
    {
        return view('books.create');
    }

    public function addBook(StoreBookRequest $request): View
    {
        $this->libraryService->addBook($request);
        return view('books.successfulRedirect', ['message' => 'Книга успешно добавлена.']);
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

    public function editBook(UpdateBookRequest $request): View
    {
        $this->libraryService->editBook($request);
        return view('books.successfulRedirect', ['message' => 'Информация о книге успешно изменена.']);
    }

    public function showFormForDeletingBook(int $bookId): View
    {
        return view('books.delete', ['bookId' => $bookId]);
    }

    public function deleteBook(int $bookId): View
    {
        $this->libraryService->deleteBook($bookId);
        return view('books.successfulRedirect', ['message' => 'Книга успешно удалена.']);
    }
}
