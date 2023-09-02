<?php

namespace App\Http\Controllers;

use App\Models\QbProject;
use App\Models\QbTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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

        QbProject::create([
            'user_id' => $user_id,
            'project_name' => $project_name,
        ]);
        return Redirect::route('dashboard');
    }

    public function projectHome(Request $request, $project_id): Response
    {
        $user_id = $request->user()->id;

        $project = QbProject::where('user_id', $user_id)
                    ->where('id', $project_id)
                    ->get();
        
        $tables = QbTable::where('project_id', $project_id)
                    ->get();

        return Inertia::render('ProjectHome', [
            'project' => $project[0],
            'tables' => $tables,
        ]);
    }

    public function uploadDdl(Request $request, $project_id): RedirectResponse
    {
        $file_name = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz0123456789'), 0, 18) . '.ddl';
        $request->file('ddlfile')->storeAs('public/',$file_name);
        return Redirect::route('get.projectHome', [
            'project_id' => $project_id,
        ]);
    }

    public function updateProject(Request $request, string $id)
    {

    }

    public function deleteProject(string $id)
    {
        
    }
}
