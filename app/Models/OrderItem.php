<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  use HasFactory;

  protected $fillable = [
    'order_id',
    'product_id',
    'name',
    'price',
    'quantity',
    'variant',
  ];

  protected $casts = [
    'price' => 'decimal:2',
    'quantity' => 'integer',
  ];

  public function order()
  {
    return $this->belongsTo(Order::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
