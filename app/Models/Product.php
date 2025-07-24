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
    'average_rating',
  ];

  protected $casts = [
    'image_paths' => 'array',
    'price' => 'decimal:2',
    'average_rating' => 'decimal:1',
  ];

  public function vendor()
  {
    return $this->belongsTo(User::class, 'vendor_id');
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }

  public function ratings()
  {
    return $this->hasMany(Rating::class);
  }

  public function updateAverageRating()
  {
    $average = $this->ratings()->avg('rating');
    $this->update(['average_rating' => $average ? round($average, 1) : null]);
  }
}