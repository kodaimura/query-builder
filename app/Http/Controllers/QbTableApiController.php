<?php

namespace App\Http\Controllers;

use App\Models\QbTable;
use App\Models\QbColumn;
use Illuminate\Support\Facades\File;
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

    public function uploadDdl(Request $request, $project_id): JsonResponse
    {
        $file_name = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz0123456789'), 0, 18) . '.ddl';
        $request->file('file')->storeAs('public/', $file_name);

        $content = File::get(storage_path('app/public/') . $file_name);
        $content = strtolower($content);
        $content = str_replace("\t", " ", $content);
        $content = str_replace("\n", " \n ", $content);
        $content = str_replace("(", " ( ", $content);
        $content = str_replace(")", " ) ", $content);
        $content = str_replace(",", " , ", $content);
        $content = str_replace(";", "", $content);

        $content_array = array_values(array_filter(explode(" ", $content), function($token) {
            return $token !== "";
        }));

        $skip_to = [];
        $expect_create_target_flg = false;
        $expect_table_name_flg = false;
        $expect_column_flg = false;
        $table_name = "";
        $columns = [];
        $tables = [];
        $line = 0;
        foreach($content_array as $key => $token) {
            if ($token == "\n") {
                $line++;
                continue;
            }

            if ($expect_column_flg && $token == ")" && !empty($skip_to) && $skip_to[0] == ",") {
                array_shift($skip_to);
                $tables[$table_name] = $columns;
                $table_name = "";
                $columns = [];
                $expect_column_flg = false;

                continue;
            }

            if (!empty($skip_to)) {
                if ($token == "(") {
                    array_unshift($skip_to, ")");
                } else if ($token == $skip_to[0]) {
                    array_shift($skip_to);
                } 
                continue;
            }

            if ($token == "create") {
                $expect_create_target_flg = true;
                $expect_table_name_flg = false;
                $expect_column_flg = false;

            } else if ($expect_create_target_flg) {
                if ($token == "table") {
                    $expect_table_name_flg = true;
                }
                $expect_create_target_flg = false;

            } else if ($expect_table_name_flg) {
                if ($token == "(") {
                    $expect_table_name_flg = false;
                    $expect_column_flg = true;
                } else {
                    $table_name = $token;
                }

            } else if ($expect_column_flg) {
                if (in_array($token, ["constraint", "primary", "unique", "foreign"])) {
                    array_unshift($skip_to, ",");
                } else {
                    array_push($columns, $token);
                    array_unshift($skip_to, ",");
                }
            }
        }

        foreach($tables as $table_name => $cols) {
            $table = QbTable::create([
                'project_id' => $project_id,
                'table_name' => $table_name,
            ]);

            foreach($cols as $column_name) {
                QbColumn::create([
                    'table_id' => $table["id"],
                    'column_name' => $column_name,
                ]);
            }
        }

        $tables = QbTable::where('project_id', $project_id)
                    ->get();
        return response()->json($tables);
    }
}
