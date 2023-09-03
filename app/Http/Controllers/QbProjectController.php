<?php

namespace App\Http\Controllers;

use App\Models\QbColumn;
use App\Models\QbProject;
use App\Models\QbTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;

class QbProjectController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('CreateProject');
    }

    public function store(Request $request): RedirectResponse
    {
        $user_id = $request->user()->id;
        $project_name = $request->project_name;

        QbProject::create([
            'user_id' => $user_id,
            'project_name' => $project_name,
        ]);
        return Redirect::route('dashboard');
    }
}
