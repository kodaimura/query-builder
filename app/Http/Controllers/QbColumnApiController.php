<?php

namespace App\Http\Controllers;

use App\Models\QbColumn;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QbColumnApiController extends Controller
{
    public function getColumns(Request $request, $table_id): JsonResponse
    {
        $columns = QbColumn::where('table_id', $table_id)
                    ->get();
        return response()->json($columns);
    }

    public function createColumn(Request $request, $table_id): JsonResponse
    {
        $column_name = $request->column_name;

        QbColumn::create([
            'table_id' => $table_id,
            'column_name' => $column_name,
        ]);

        $columns = QbColumn::where('table_id', $table_id)
                    ->get();
        return response()->json($columns);
    }

    public function deleteColumn(Request $request, $table_id, $column_id): JsonResponse
    {
        QbColumn::where('id', $column_id)->delete();

        $columns = QbColumn::where('table_id', $table_id)
                    ->get();
        return response()->json($columns);
    }
}
