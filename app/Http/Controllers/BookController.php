<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Отобразить список ресурсов.
     */
    public function index()
    {
        return view('books.index');
    }

    /**
     * Показать форму создания нового ресурса.
     */
    public function create()
    {
        //
    }

    /**
     * Сохраните вновь созданный ресурс в хранилище.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Показать форму редактирования указанного ресурса.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Обновите указанный ресурс в хранилище.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Удалить указанный ресурс из хранилища.
     */
    public function destroy(string $id)
    {
        //
    }
}
