<?php

namespace App\Services;

use App\Exceptions\AttemptWasMadeToDeleteAuthorThatIsNotInAuthorsTable;
use App\Exceptions\AuthorsFullNameMustBeUnique;
use App\Exceptions\ChangerLibraryServiceException;
use App\Exceptions\TryingToRemoveAuthorThatIsNotRelatedToBook;
use App\Exceptions\TryingToRemoveOnlyAuthorOfBook;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\AuthorBook;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use PHPUnit\Logging\Exception;

class ChangerLibraryService
{
    public function __construct(private readonly HelperForCreatorAndChanger $helper){}

    /**
     * @throws \Exception
     */
    public function editBook(UpdateBookRequest $request): void
    {
        $formData = $request->all();

        $urlReferer = $request->session()->all()['_previous']['url'];

        $bookId = $this->getBookIdFromUrlReferer($urlReferer);

        $bookInformation['title'] = $formData['title'];
        $bookInformation['description'] = $formData['description'];
        $bookInformation['year_of_publication'] = $formData['year_of_publication'];

        $listOfChangedFieldsExceptAuthors = $this->getListOfChangedFieldsExceptAuthors($bookInformation, $bookId);

        try {
            DB::beginTransaction();

            if (!empty($listOfChangedFieldsExceptAuthors)) {
                $this->updateBookInformationExceptAuthors($listOfChangedFieldsExceptAuthors, $formData, $bookId);
            }

            $this->changeAuthorsFullName($this->helper->getListOfAuthors($formData['originalOrModifiedAuthors']));

            if ($formData['deletedAuthors'] !== null) {
                $this->removeAuthorFromBook($this->helper->getListOfAuthors($formData['deletedAuthors']), $bookId);
            }

            if ($formData['newAuthors'] !== null) {
                $this->addAuthorToBook($this->helper->getListOfAuthors($formData['newAuthors']), $bookId);
            }

            DB::commit();
        } catch (ChangerLibraryServiceException $e) {
            DB::rollBack();
            throw new ChangerLibraryServiceException($e->getMessage());
        }
    }

    private function getBookIdFromUrlReferer(string $urlReferer): int
    {
        $id = [];
        preg_match_all('/\/[0-9]*$/', $urlReferer, $id);
        return intval(mb_substr($id[0][0], 1));
    }

    private function getListOfChangedFieldsExceptAuthors(array $bookInformation, int $bookId): array
    {
        $result = [];
        foreach ($bookInformation as $fieldName => $valueFromForm) {
            $valueFromDatabase = Book::query()->where('id', '=', $bookId)->get($fieldName)->first()->$fieldName;
            $valueFromForm = ($fieldName === 'year_of_publication') ? intval($valueFromForm) : $valueFromForm;
            if ($valueFromForm !== $valueFromDatabase) {
                $result[] = $fieldName;
            }
        }
        return $result;
    }

    private function updateBookInformationExceptAuthors(array $listOfChangedFields, array $newData, int $bookId): void
    {
        $book = Book::find($bookId);
        foreach ($listOfChangedFields as $fieldName) {
            $book->$fieldName = $newData[$fieldName];
        }
        $book->save();
    }

    /**
     * @throws AttemptWasMadeToDeleteAuthorThatIsNotInAuthorsTable
     * @throws TryingToRemoveOnlyAuthorOfBook
     * @throws TryingToRemoveAuthorThatIsNotRelatedToBook
     */
    private function removeAuthorFromBook(array $authorsToBeDeleted, int $bookId): void
    {
        $idOfAuthorsToBeDeleted = array_map(/**
         * @throws AttemptWasMadeToDeleteAuthorThatIsNotInAuthorsTable
         */ function ($authorsFullName) {
            $id = Author::query()->where('full_name', '=', $authorsFullName)->get('id')->first();

            if ($id === null) {
                throw new AttemptWasMadeToDeleteAuthorThatIsNotInAuthorsTable("Нельзя удалить автора у книги, если такого автора нет в библиотеки.");
            }
            return $id->id;
        }, $authorsToBeDeleted);

        $idOfAuthorsAssociatedWithBook = array_map(function ($author) {
            return $author->id;
        }, Book::find($bookId)->authors()->get(['id'])->all());

        if (count($idOfAuthorsAssociatedWithBook) === 1) {
            if (!empty(array_intersect($idOfAuthorsToBeDeleted, $idOfAuthorsAssociatedWithBook))) {
                throw new TryingToRemoveOnlyAuthorOfBook("Вы пытаетесь удалить единственного автора у книги. Книга в этой библиотеке не может существовать без автора, поэтому сайт отказал Вам в выполнении вашего запроса.");
            }
        }

        foreach ($idOfAuthorsToBeDeleted as $authorId) {

            if (!in_array($authorId, $idOfAuthorsAssociatedWithBook)) {
                throw new TryingToRemoveAuthorThatIsNotRelatedToBook("Вы пытаетесь удалить автора, который не относится к этой книге.");
            }

            $additionalCheckForNumberOfAuthorsAssociatedWithBook = array_map(function ($author) {
                return $author->id;
            }, Book::find($bookId)->authors()->get(['id'])->all());

            if (count($additionalCheckForNumberOfAuthorsAssociatedWithBook) === 1) {
                if (!empty(array_intersect($idOfAuthorsToBeDeleted, $idOfAuthorsAssociatedWithBook))) {
                    throw new TryingToRemoveOnlyAuthorOfBook("Вы пытаетесь удалить единственного автора у книги. Книга в этой библиотеке не может существовать без автора, поэтому сайт отказал Вам в выполнении вашего запроса.");
                }
            }

            DB::table('author_book')->where('author_id', '=', $authorId)->where('book_id', '=', $bookId)->delete();

            $numberOfBooksWrittenByAuthors = AuthorBook::query()->where('author_id', '=', $authorId)->count();
            if ($numberOfBooksWrittenByAuthors === 0) {
                DB::table('authors')->where('id', '=', $authorId)->delete();
            }
        }
    }

    private function addAuthorToBook(array $authorsToAdd, int $bookId): void
    {
        foreach ($authorsToAdd as $authorsFullName) {

            $numberOfAuthorsWithThisFullName = Author::query()->where('full_name', '=', $authorsFullName)->count();

            if (!$numberOfAuthorsWithThisFullName) {
                $author = new Author();
                $author->full_name = trim($authorsFullName);
                $author->save();
            }

            $communication = new AuthorBook();
            $communication->author_id = $author->id ?? Author::query()->where('full_name', '=', $authorsFullName)->get('id')->first()->id;
            $communication->book_id = $bookId;
            $communication->save();
        }

    }

    /**
     * @throws AuthorsFullNameMustBeUnique
     */
    private function changeAuthorsFullName(array $listOfAuthors): void
    {
        foreach ($listOfAuthors as $author) {
            if (preg_match('/\([а-яё ]*\)$/ui', $author)) {

                $oldFullName = preg_split('/^[а-яё ]*/ui', $author, -1, PREG_SPLIT_NO_EMPTY);
                $oldFullName = trim(mb_substr($oldFullName[0], 1, mb_strlen($oldFullName[0])-2));

                $newFullName = preg_split('/\([а-яё ]*\)$/ui', $author, -1, PREG_SPLIT_NO_EMPTY);
                $newFullName = trim($newFullName[0]);

                $numberOfAuthorsWithThisFullName = Author::query()->where('full_name', '=', $newFullName)->count();

                if ($numberOfAuthorsWithThisFullName !== 0) {
                    throw new AuthorsFullNameMustBeUnique("В библиотеке не может быть двух авторов с одинаковым именем. Вы пытаетесь изменить ФИО определенного автора на ФИО автора, который уже есть в библиотеке.");
                }

                $authorId = Author::query()->where('full_name', '=', $oldFullName)->get('id')->first()->id;

                $authorModel = Author::find($authorId);
                $authorModel->full_name = $newFullName;
                $authorModel->save();
            }
        }
    }
}
