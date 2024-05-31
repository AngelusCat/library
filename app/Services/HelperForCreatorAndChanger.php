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

    public function getBookIdFromUrlReferer(string $urlReferer): int
    {
        $id = [];
        preg_match_all('/\/[0-9]*$/', $urlReferer, $id);
        return intval(mb_substr($id[0][0], 1));
    }
}
