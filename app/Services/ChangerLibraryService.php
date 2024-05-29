<?php

namespace App\Services;

use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\AuthorBook;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class ChangerLibraryService
{
    public function __construct(private readonly HelperForCreatorAndChanger $helper){}

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
        } catch (\Exception $e) {
            DB::rollBack();
            dump($e);
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

    private function removeAuthorFromBook(array $authorsToBeDeleted, int $bookId): void
    {
        $idOfAuthorsToBeDeleted = array_map(function ($authorsFullName) {
            $id = Author::query()->where('full_name', '=', $authorsFullName)->get('id')->first();

            if ($id === null) {
                die('Попытка удалить автора, которого нет в таблице authors');
            }
            return $id->id;
        }, $authorsToBeDeleted);

        $idOfAuthorsAssociatedWithBook = array_map(function ($author) {
            return $author->id;
        }, Book::find($bookId)->authors()->get(['id'])->all());

        if (count($idOfAuthorsAssociatedWithBook) === 1) {
            if (!empty(array_intersect($idOfAuthorsToBeDeleted, $idOfAuthorsAssociatedWithBook))) {
                die('Нельзя удалять автора у книги, если он единственный у нее. Книга не может быть без автора');
            }
        }

        foreach ($idOfAuthorsToBeDeleted as $authorId) {

            //Сделать проверку, что удаляемый id есть в $idOfAuthorsAssociatedWithBook

            if (!in_array($authorId, $idOfAuthorsAssociatedWithBook)) {
                die ('Автор отвязывается только от своей книги');
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

    private function changeAuthorsFullName(array $listOfAuthors): void
    {
        foreach ($listOfAuthors as $author) {
            if (preg_match('/\([а-яё ]*\)$/ui', $author)) {

                $oldFullName = preg_split('/^[а-яё ]*/ui', $author, -1, PREG_SPLIT_NO_EMPTY);
                $oldFullName = trim(mb_substr($oldFullName[0], 1, mb_strlen($oldFullName[0])-2));

                $newFullName = preg_split('/\([а-яё ]*\)$/ui', $author, -1, PREG_SPLIT_NO_EMPTY);
                $newFullName = trim($newFullName[0]);

                //Проверка, что авторов с ФИО === $newFullName нет в таблице authors

                $numberOfAuthorsWithThisFullName = Author::query()->where('full_name', '=', $newFullName)->count();

                if ($numberOfAuthorsWithThisFullName !== 0) {
                    die('Нельзя изменять ФИО автора на то, которое занято другим автором.');
                }

                $authorId = Author::query()->where('full_name', '=', $oldFullName)->get('id')->first()->id;

                $authorModel = Author::find($authorId);
                $authorModel->full_name = $newFullName;
                $authorModel->save();
            }
        }
    }
}
