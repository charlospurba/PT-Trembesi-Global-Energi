<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PMRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_name',
        'procurement_kode',
        'item',
        'specification',
        'unit',
        'qty',
        'eta',
        'remark',
        'price',
    ];

    protected $casts = [
        'eta' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}