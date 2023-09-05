<?php

namespace App\Http\Controllers;

use App\Models\QbTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QbTableController extends Controller
{
    /*
    public function create(): Response
    {
        return Inertia::render('CreateTable');
    }
    */
    
    public function store(Request $request, $project_id): RedirectResponse
    {
        $table_name = $request->table_name;

        QbTable::create([
            'project_id' => $project_id,
            'table_name' => $table_name,
        ]);
        return Redirect::route('projectDashboard', [
            'project_id' => $project_id
        ]);
    }
}
