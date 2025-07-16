<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'product_id',
    'cart_id',
    'quantity',
    'price',
    'supplier',
    'status',
    'notes',
    'submitted_at',
    'approved_at',
    'rejected_at',
  ];

  protected $casts = [
    'submitted_at' => 'datetime',
    'approved_at' => 'datetime',
    'rejected_at' => 'datetime',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function cart()
  {
    return $this->belongsTo(Cart::class);
  }
}