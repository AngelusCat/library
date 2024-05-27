<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/addBook', [\App\Http\Controllers\LibraryController::class, 'showFormToAddBook']);
Route::post('/addBook', [\App\Http\Controllers\LibraryController::class, 'addBook']);
