<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/addBook', [\App\Http\Controllers\LibraryController::class, 'askRegistryToIssueFormForInventoryingNewBook']);
Route::post('/addBook', [\App\Http\Controllers\LibraryController::class, 'submitCompletedFormToRegistry']);
