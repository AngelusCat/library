<?php

namespace App\Http\Controllers;

use App\Exceptions\ChangerLibraryServiceException;
use App\Exceptions\CreatorLibraryServiceException;
use App\Exceptions\RemoverLibraryServiceException;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\AuthorBook;
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

    public function showFullInformationAboutBook(int $bookId): View
    {
        $book = $this->libraryService->getFullInformationAboutBook($bookId);
        return view('books.show', ['book' => $book]);
    }

    public function showListOfAuthors(): View
    {
        $listOfAuthors = $this->libraryService->getListOfAuthors();
        return view('authors.index', ['listOfAuthors' => $listOfAuthors]);
    }

    public function showFullInformationAboutAuthor(int $authorId): View
    {
        $author = $this->libraryService->getFullInformationAboutAuthor($authorId);
        $numberOfBooksWritten = AuthorBook::query()->where('author_id', '=', $author->id)->count();
        return view('authors.show', ['author' => $author, 'numberOfBooksWritten' => $numberOfBooksWritten]);
    }

    public function showFormToAddBook(): View
    {
        return view('books.create');
    }

    public function addBook(StoreBookRequest $request): View
    {
        try {
            $this->libraryService->addBook($request);
        } catch (CreatorLibraryServiceException $e) {
            abort('500');
        }

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
        try {
            $this->libraryService->editBook($request);
        } catch (ChangerLibraryServiceException $e) {
            return view('books.unsuccessfulRedirect', ['message' => $e->getMessage()]);
        }
        return view('books.successfulRedirect', ['message' => 'Информация о книге успешно изменена.']);
    }

    public function showFormForDeletingBook(int $bookId): View
    {
        return view('books.delete', ['bookId' => $bookId]);
    }

    public function deleteBook(int $bookId): View
    {
        try {
            $this->libraryService->deleteBook($bookId);
        } catch (RemoverLibraryServiceException $e) {
            abort(500);
        }
        return view('books.successfulRedirect', ['message' => 'Книга успешно удалена.']);
    }
}
