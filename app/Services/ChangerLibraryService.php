<?php

namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\AuthorBook;
use App\Models\Book;

class ChangerLibraryService
{
    public function __construct(private readonly HelperForCreatorAndChanger $helper){}
    public function editBook(BookRequest $request): void
    {
        $urlReferer = $request->session()->all()['_previous']['url'];

        $bookId = $this->getBookIdFromUrlReferer($urlReferer);

        $data = $request->all();

        $data['id'] = $bookId;

        $listOfChangedFields = $this->getListOfChangedFields($data);

        if (empty($listOfChangedFields)) {
            //Нечего изменять
            die;
        }
    }

     private function getListOfChangedFields(array $formData): array
     {
         $result = [];

         foreach ($formData as $fieldName => $newValue) {
             if ($fieldName === 'title'| $fieldName === 'description' | $fieldName === 'year_of_publication') {

                 $oldValue = Book::query()->where('id', '=', $formData['id'])->get($fieldName)->first()->$fieldName;

                 $newValue = ($fieldName === 'year_of_publication') ? intval($newValue) : $newValue;

                 if ($oldValue !== $newValue) {
                     $result[] = $fieldName;
                 }
             } else if ($fieldName === 'authors') {
                 $changedAuthors = $this->getListOfChangedAuthors($newValue, $formData['id']);
                 if ($changedAuthors[0] !== null) {
                     $result['authors'] = $changedAuthors;
                 }
             }
         }

         return $result;

     }

     private function getBookIdFromUrlReferer(string $urlReferer): int
     {
         $id = [];
         preg_match_all('/\/[0-9]*$/', $urlReferer, $id);

         return intval(mb_substr($id[0][0], 1));
     }

    private function getListOfChangedAuthors(string $authorsLine, int $bookId): array
    {
        $arrayOfAuthors = $this->helper->getListOfAuthors($authorsLine);

        $authorsIds = array_map(function (Author $authorsModel) {
            return $authorsModel->id;
        }, Book::find($bookId)->authors->all());

        return array_map(function (string $newFullName, int $oldAuthorId) {
            $oldFullName = Author::query()->where('id', '=', $oldAuthorId)->get('full_name')->first()->full_name;
            if ($newFullName !== $oldFullName) {
                return $newFullName;
            }
        }, $arrayOfAuthors, $authorsIds);
    }
}
