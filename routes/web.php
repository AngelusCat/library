<?php

use App\Http\Controllers\ProfileController;
use App\Models\AuthorBook;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/books', [\App\Http\Controllers\LibraryController::class, 'showListOfBooks']);
Route::get('/authors', [\App\Http\Controllers\LibraryController::class, 'showListOfAuthors']);
Route::get('/addBook', [\App\Http\Controllers\LibraryController::class, 'showFormToAddBook'])->middleware('auth');
Route::post('/addBook', [\App\Http\Controllers\LibraryController::class, 'addBook'])->middleware('auth');
Route::get('/editBook/{book_id}', [\App\Http\Controllers\LibraryController::class, 'showFormToEditBook'])->middleware('auth');
Route::patch('/editBook', [\App\Http\Controllers\LibraryController::class, 'editBook'])->middleware('auth');
Route::get('/deleteBook/{book_id}', [\App\Http\Controllers\LibraryController::class, 'showFormForDeletingBook'])->middleware('auth');
Route::delete('/deleteBook/{book_id}', [\App\Http\Controllers\LibraryController::class, 'deleteBook'])->name('deleteBook')->middleware('auth');
Route::get('showBook/{book_id}', [\App\Http\Controllers\LibraryController::class, 'showFullInformationAboutBook']);
Route::get('showAuthor/{author_id}', [\App\Http\Controllers\LibraryController::class, 'showFullInformationAboutAuthor']);
Route::get('/test/{author_id}', function ($authorId) {
    $number = AuthorBook::query()->where('author_id', '=', $authorId)->count();
    return response()->json($number);
});

require __DIR__.'/auth.php';
