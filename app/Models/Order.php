<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_email',
        'customer_phone',
        'customer_first_name',
        'customer_last_name',
        'shipping_address',
        'shipping_apartment',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'shipping_method',
        'payment_method',
        'subtotal',
        'shipping_cost',
        'tax',
        'discount',
        'total',
        'notes',
        'status',
        'payment_status',
        'transaction_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
