<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
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

    public function addBook(BookRequest $request): void
    {
        $this->libraryService->addBook($request);
    }

    public function submitCompletedFormToRegistry(Request $request): void
    {
        $this->libraryService->acceptBookInventoryForm($request);
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
