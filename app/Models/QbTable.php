<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QbTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'table_name',
    ];
}
