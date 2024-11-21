<?php

namespace IBroStudio\PaymentMethodManager\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class Gateway extends Model
{
    use HasDataRepository;
    use HasFactory;

    protected $table = 'payment_gateways';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'class',
        'icon',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => DataObjectCast::class,
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Model $gateway) {
            $gateway->class = get_called_class();
        });
    }

    public function methods(): HasMany
    {
        return $this->hasMany(Method::class);
    }
}
