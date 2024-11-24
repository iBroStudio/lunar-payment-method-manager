<?php

namespace IBroStudio\PaymentMethodManager\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\PaymentMethodManager\Concerns\HasChildrenModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gateway extends Model
{
    use HasChildrenModels;
    use HasDataRepository;

    protected $table = 'payment_gateways';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'class',
    ];

    protected static function booted(): void
    {
        static::creating(function (Model $gateway) {
            $gateway->class = get_called_class();
        });
    }

    protected function casts(): array
    {
        return [
            'credentials' => DataObjectCast::class,
        ];
    }

    public function getMorphClass()
    {
        return $this->class;
    }

    public function methods(): HasMany
    {
        return $this->hasMany(Method::class, 'gateway_id');
    }
}
