<?php

namespace App\Http\Controllers;

use App\Models\QbProject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function show(Request $request): Response
    {
        $user_id = $request->user()->id;

        $projects = QbProject::where('user_id', $user_id)
                    ->get();
        return Inertia::render('Dashboard', [
            'projects' => $projects
        ]);
    }
}
