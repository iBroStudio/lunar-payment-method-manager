<?php

namespace IBroStudio\PaymentMethodManager\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\PaymentMethodManager\Concerns\HasChildrenModels;
use IBroStudio\PaymentMethodManager\Enums\PaymentMethodStatesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lunar\Models\Customer;

class CustomerMethod extends Model
{
    use HasChildrenModels;
    use HasDataRepository;

    protected $table = 'payment_customer_methods';

    protected $fillable = [
        'class',
        'method_id',
        'customer_id',
        'state',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => DataObjectCast::class,
            'state' => PaymentMethodStatesEnum::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
