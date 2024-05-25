<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistryService
{
    public function __construct(private readonly InventoryMaker $inventoryMaker, private KeeperOfInventories $keeperOfInventories){}

    /**
     * Выдать бланк на опись
     * @return View
     */

    public function issueForm(): View
    {
        return view('books.create');
    }

    /**
     * Принять заполненный бланк и попытаться сделать опись
     * @param Request $request
     * @return void
     */

    public function acceptBookInventoryForm(Request $request): void
    {
        $this->inventoryMaker->makeInventory($request);
    }

    /**
     * Уничтожает опись определенной книги и сдает книгу в утиль
     * @param int $id
     * @return void
     */

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
