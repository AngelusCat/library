<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::resources([
    'books' => BookController::class,
    'authors' => AuthorController::class,
]);
