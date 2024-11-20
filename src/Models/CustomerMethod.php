<?php

namespace IBroStudio\PaymentMethodManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lunar\Models\Customer;

class CustomerMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_customer_methods';

    protected $fillable = [
        'method_id',
        'customer_id',
        'state',
    ];

    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
