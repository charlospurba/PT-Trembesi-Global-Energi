<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
  use HasFactory;

  protected $fillable = [
    'order_id',
    'product_id',
    'user_id',
    'rating',
  ];

  protected $casts = [
    'rating' => 'integer',
  ];

  public function order()
  {
    return $this->belongsTo(Order::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}