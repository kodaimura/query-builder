<?php

namespace App\Http\Controllers;

use App\Models\QbProject;
use App\Models\QbTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QbProjectDashboardController extends Controller
{

    public function show(Request $request, $project_id): Response
    {
        $user_id = $request->user()->id;

        $project = QbProject::where('user_id', $user_id)
                    ->where('id', $project_id)
                    ->get();
        
        $tables = QbTable::where('project_id', $project_id)
                    ->get();

        return Inertia::render('ProjectDashboard', [
            'project' => $project[0],
            'tables' => $tables,
        ]);
    }
}
