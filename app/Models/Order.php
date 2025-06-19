<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<string>
   */
  protected $fillable = [
    'user_id',
    'vendor',
    'total_price',
    'full_name',
    'country',
    'postal_code',
    'street_address',
    'state',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'total_price' => 'decimal:2',
  ];

  /**
   * Get the user that owns the order.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Get the items for the order.
   */
  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }
}