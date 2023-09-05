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

class QbColumnController extends Controller
{
    public function getColumns(Request $request, $table_id): JsonResponse
    {
        $columns = QbColumn::where('table_id', $table_id)
                    ->get();
        return response()->json($columns);
    }
}
