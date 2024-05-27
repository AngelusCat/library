<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/addBook', [\App\Http\Controllers\LibraryController::class, 'showFormToAddBook']);
Route::post('/addBook', [\App\Http\Controllers\LibraryController::class, 'addBook']);
Route::get('/editBook/{book_id}', [\App\Http\Controllers\LibraryController::class, 'showFormToEditBook']);
Route::patch('/editBook', [\App\Http\Controllers\LibraryController::class, 'editBook']);
