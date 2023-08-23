<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QbColumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'column_name',
    ];
}
