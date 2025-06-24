<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'vendor',
    'total_price',
    'full_name',
    'country',
    'postal_code',
    'street_address',
    'state',
    'city',
    'status',
  ];

  protected $casts = [
    'total_price' => 'decimal:2',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }
}