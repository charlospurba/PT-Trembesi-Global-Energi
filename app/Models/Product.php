<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  protected $fillable = [
    'vendor_id',
    'category',
    'supplier',
    'brand',
    'name',
    'specification',
    'unit',
    'quantity',
    'price',
    'description',
    'address',
    'image_paths',
  ];

  protected $casts = [
    'image_paths' => 'array',
  ];
}