<?php

namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryService
{
    public function __construct
    (
        private readonly CreatorLibraryService $creator,
        private readonly ChangerLibraryService $changer,
        private readonly RemoverLibraryService $remover,
        private readonly FinderLibraryService $finder
    ){}

    public function addBook(BookRequest $request): void
    {
        $this->creator->addBook($request);
    }

    public function editBook(BookRequest $request): void
    {
        $this->changer->editBook($request);
    }

    public function destroyInventoryOfSpecificBook(int $id)
    {

    }

    /**
     * Возвращает список описей книг с краткой информацией
     * @return void
     */

    public function getListOfAllBooks()
    {
        $this->keeperOfInventories->getQuickSummaryOfBook();
    }

    /**
     * Возвращает список описей авторов с краткой информацией
     * @return void
     */

    public function getListOfAllAuthors()
    {
        $this->keeperOfInventories->getBriefInformationAboutAuthor();
    }

    public function getCompleteInformationAboutBook()
    {
        $this->keeperOfInventories->getCompleteInformationAboutBook();
    }

    public function getCompleteInformationAboutAuthor()
    {
        $this->keeperOfInventories->getFullInformationAboutAuthor();
    }

}
