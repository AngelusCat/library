<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class InventoryMaker
{
    public function makeInventory(Request $request): void
    {
        $validated = $this->validateBookInventoryForm($request);
        $this->addBookInventoryToRegister($validated);
    }

    private function validateBookInventoryForm(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|regex:/^[a-zа-яё0-9\-\.: ,]{1,120}$/ui',
            'authors' => "required|string|regex:/^[a-zа-яё' \(\)\-,]*$/ui",
            'description' => 'nullable|string',
            'yearOfPublication' => 'required|integer|regex:/^-?[1-9]{1}[0-9]{2,3}$/|min:-600|max:' . date('Y')
        ]);
    }

    private function addBookInventoryToRegister(array $data): void
    {
        $book = new Book();
        $book->title = $data['title'];
        $book->description = $data['description'];
        $book->year_of_publication = $data['yearOfPublication'];
        $book->save();

        $authors = $this->getListOfAuthorsFromString($data['authors']);

        $authorsId = $this->getAuthorsId($authors, $data['title']);

    }

    private function getListOfAuthorsFromString(string $authors): array
    {
        $result = explode(',',$authors);

        return array_map(function ($value) {
            return trim($value);
        }, $result);
    }

    private function getAuthorsId(array $authors, string $title): array
    {
        $books = Book::query()->get();
        dump($books);
        dump($books->authors);

        return [];
    }
}
