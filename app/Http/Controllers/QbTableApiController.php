<?php

namespace App\Http\Controllers;

use App\Models\QbTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QbTableApiController extends Controller
{

    public function getTables(Request $request, $project_id): JsonResponse
    {
        $tables = QbTable::where('project_id', $project_id)
                    ->get();
        return response()->json($tables);
    }

    public function createTable(Request $request, $project_id): JsonResponse
    {
        $table_name = $request->table_name;

        QbTable::create([
            'project_id' => $project_id,
            'table_name' => $table_name,
        ]);

        $tables = QbTable::where('project_id', $project_id)
                    ->get();
        return response()->json($tables);
    }

    public function deleteTable(Request $request, $project_id, $table_id): JsonResponse
    {
        QbTable::where('id', $table_id)->delete();

        $tables = QbTable::where('project_id', $project_id)
                    ->get();
        return response()->json($tables);
    }

    public function updatetable(Request $request, $project_id, $table_id): JsonResponse
    {
        $table_name = $request->table_name;

        QbTable::where('id', $table_id)->update([
            'project_id' => $project_id,
            'table_name' => $table_name,
        ]);

        $tables = QbTable::where('project_id', $project_id)
                    ->get();
        return response()->json($tables);
    }
}
