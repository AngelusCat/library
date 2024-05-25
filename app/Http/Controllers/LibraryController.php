<?php

namespace App\Http\Controllers;

use App\Services\RegistryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function __construct(private readonly RegistryService $registryService) {}

    /**
     * Обращается к реестру и просит его выдать бланк на опись новой книги
     * @return View
     */

    //public function makeRequestToAddBook(): View
    public function askRegistryToIssueFormForInventoryingNewBook(): View
    {
        return $this->registryService->issueForm();
    }

    /**
     * Обращается к реестру и просит его выдать бланк на изменение описи имеющейся книги
     * @return View
     */

    public function makeRequestToChangeInformationAboutBook(): View
    {
        $this->registryService->issueBookInventoryForm();
    }

    /**
     * Принимает заполненный бланк от пользователя и передает его реестру
     * @param Request $request
     * @return void
     */

    //public function giveCompletedFormToRegistry(Request $request)
    public function submitCompletedFormToRegistry(Request $request): void
    {
        $this->registryService->acceptBookInventoryForm($request);
    }

    /**
     * Просит реестр избавиться от описи определенной книги и сдать ее в утиль
     * @param int $id
     * @return void
     */

    public function getRidOfBook(int $id)
    {
        $this->registryService->destroyInventoryOfSpecificBook($id);
    }

    /**
     * Просит реестр создать список описей книг с краткой информацией
     * @return void
     */

    public function getListOfBooks()
    {
        $this->registryService->getListOfAllBooks();
    }

    /**
     * Просит реестр создать список описей авторов с краткой информацией
     * @return void
     */

    public function getListOfAuthors()
    {
        $this->registryService->getListOfAllAuthors();
    }

    public function getCompleteInformationAboutBook()
    {

    }

    public function getCompleteInformationAboutAuthor()
    {

    }
}
