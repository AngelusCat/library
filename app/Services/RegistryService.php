<?php

namespace App\Services;

use App\Models\Book;
use http\Env\Request;
use Illuminate\View\View;

class RegistryService
{
    public function __construct(private readonly BookDescriptor $bookDescriptor){}

    public function issueBookInventoryForm(): View
    {
        return view('books.create');
    }

    public function acceptBookInventoryForm(Request $request)
    {
        $this->bookDescriptor->makeInventoryOfBook($request);
    }

}
