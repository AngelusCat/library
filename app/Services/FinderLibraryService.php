<?php

namespace App\Services;

use App\Models\Book;

class FinderLibraryService
{
    public function getListOfBooks(): array
    {
        return Book::all()->all();
    }
}
