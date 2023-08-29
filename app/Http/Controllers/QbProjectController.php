<?php

namespace App\Http\Controllers;

use App\Models\QbProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QbProjectController extends Controller
{
    public function getProjects(Request $request): JsonResponse
    {
        $user_id = $request->user()->id;

        $projects = QbProject::where('user_id', $user_id)
                    ->get();
        return response()->json($projects);
    }

    public function createProject(Request $request): RedirectResponse
    {
        $user_id = $request->user()->id;
        $project_name = $request->project_name;

        $project = QbProject::create([
            'user_id' => $user_id,
            'project_name' => $project_name,
        ]);
        return Redirect::route('dashboard');
    }

    public function updateProject(Request $request, string $id)
    {

    }

    public function deleteProject(string $id)
    {
        
    }
}
