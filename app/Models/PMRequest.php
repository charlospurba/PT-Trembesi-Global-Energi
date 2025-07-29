<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PMRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'qty',
        'unit',
        'commcode',
        'description',
        'specification',
        'required_delivery_date',
        'remarks',
        'project_name',
    ];

    protected $casts = [
        'required_delivery_date' => 'date',
    ];
}

