<?php

use Illuminate\Support\Facades\Route;

Route::get('/books', [\App\Http\Controllers\LibraryController::class, 'showListOfBooks']);
Route::get('/addBook', [\App\Http\Controllers\LibraryController::class, 'showFormToAddBook']);
Route::post('/addBook', [\App\Http\Controllers\LibraryController::class, 'addBook']);
Route::get('/editBook/{book_id}', [\App\Http\Controllers\LibraryController::class, 'showFormToEditBook']);
Route::patch('/editBook', [\App\Http\Controllers\LibraryController::class, 'editBook']);
Route::get('/deleteBook/{book_id}', [\App\Http\Controllers\LibraryController::class, 'showFormForDeletingBook']);
Route::delete('/deleteBook/{book_id}', [\App\Http\Controllers\LibraryController::class, 'deleteBook']);
