<?php

namespace App\Services;

use App\Models\Author;
use App\Models\AuthorBook;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use PHPUnit\Logging\Exception;

class RemoverLibraryService
{
    public function deleteBook(int $bookId): void
    {
        $book = Book::find($bookId);

        $idsOfAuthorsAssociatedWithBook = array_map(function ($author) {
            return $author->id;
        }, $book->authors->all());

        try {
            DB::beginTransaction();

            foreach ($idsOfAuthorsAssociatedWithBook as $authorId) {

                $numberOfBooksWrittenByAuthor = AuthorBook::query()->where('author_id', '=', $authorId)->count();

                DB::table('author_book')->where('author_id', '=', $authorId)->where('book_id', '=', $bookId)->delete();
                if ($numberOfBooksWrittenByAuthor === 1) {
                    DB::table('authors')->where('id', '=', $authorId)->delete();
                }
            }
            $book->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
