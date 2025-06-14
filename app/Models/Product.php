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
    'brand',
    'supplier',
    'name',
    'specification',
    'custom_spec',
    'quantity',
    'description',
    'address',
    'price',
    'image_path',
  ];
}