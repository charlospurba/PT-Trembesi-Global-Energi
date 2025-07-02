<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'product_id',
    'vendor_id',
    'bid_price',
    'status',
  ];

  protected $casts = [
    'bid_price' => 'decimal:2',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function vendor()
  {
    return $this->belongsTo(User::class, 'vendor_id');
  }
}