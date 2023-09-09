<?php

namespace App\Http\Controllers;

use App\Models\QbProject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QbQueryBuildController extends Controller
{

    public function show(Request $request, $project_id): Response
    {
        $user_id = $request->user()->id;

        $project = QbProject::where('user_id', $user_id)
                    ->where('id', $project_id)
                    ->get();

        return Inertia::render('QueryBuild', [
            'project' => $project[0],
        ]);
    }
}