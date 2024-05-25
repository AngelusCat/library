<?php

namespace App\Http\Controllers;

use App\Services\RegistryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    private RegistryService $registryService;
    public function makeRequestToAddBook(): View
    {
        return $this->registryService->issueBookInventoryForm();
    }

    public function giveCompletedFormToRegistry(Request $request)
    {
        $this->registryService->acceptBookInventoryForm();
    }
}
