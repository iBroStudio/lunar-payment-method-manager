<?php

namespace IBroStudio\PaymentMethodManager\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\PaymentMethodManager\Concerns;
use IBroStudio\PaymentMethodManager\Enums\PaymentMethodStatesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lunar\Models\Customer;

class CustomerMethod extends Model
{
    use Concerns\HasChildrenModels;
    use Concerns\HasCredentialsComponentsForm;
    use HasDataRepository;

    public static string $dataClass;

    protected $table = 'payment_customer_methods';

    protected $fillable = [
        'class',
        'method_id',
        'customer_id',
        'state',
        'credentials',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => DataObjectCast::class . (isset(static::$dataClass) ? ':' . static::$dataClass : ''),
            'state' => PaymentMethodStatesEnum::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeActive($query)
    {
        return $query->where('state', PaymentMethodStatesEnum::ACTIVE);
    }
}
