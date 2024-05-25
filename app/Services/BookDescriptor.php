<?php

namespace App\Services;

use http\Env\Request;

class BookDescriptor
{
    public function makeInventoryOfBook(Request $request): void
    {
        $validate = $this->validateBookInventoryForm();
        if (!$validate) {
            die;
        }
        $this->addBookInventoryToRegister();
    }

    private function validateBookInventoryForm(): bool
    {
        return true;
    }

    private function addBookInventoryToRegister()
    {

    }
}
