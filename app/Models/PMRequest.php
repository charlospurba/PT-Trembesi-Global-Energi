<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PMRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'item',
        'specification',
        'unit',
        'qty',
        'eta',
        'remark',
    ];

    protected $casts = [
        'eta' => 'date',
    ];
}

