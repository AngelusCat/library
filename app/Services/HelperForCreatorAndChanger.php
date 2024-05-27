<?php

namespace App\Services;

class HelperForCreatorAndChanger
{
    public function getListOfAuthors(string $authorsLine): array
    {
        $authorsArray = explode(',', $authorsLine);
        return array_map(function (string $author) {
            return trim($author);
        }, $authorsArray);
    }
}
