<?php

namespace IBroStudio\PaymentMethodManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lunar\Models\Cart;
use Lunar\Models\Order;

class PaymentIntent extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'order_id',
        'method_id',
        'gateway_intent_id',
        'status',
        'event_id',
        'processing_at',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'processing_at' => 'timestamp',
            'processed_at' => 'timestamp',
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class, 'method_id');
    }
}
