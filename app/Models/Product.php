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
    'status',
  ];

  protected $casts = [
    'image_paths' => 'array',
    'price' => 'decimal:2',
  ];

  public function vendor()
  {
    return $this->belongsTo(User::class, 'vendor_id');
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }
}
