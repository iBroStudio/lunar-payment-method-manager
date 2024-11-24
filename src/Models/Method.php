<?php

namespace IBroStudio\PaymentMethodManager\Models;

use IBroStudio\PaymentMethodManager\Concerns\HasChildrenModels;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    use HasChildrenModels;

    protected $table = 'payment_methods';

    public static string $defaultIcon = 'lucide-credit-card';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'class',
        'gateway_id',
        'description',
        'icon',
        'active',
    ];

    protected $casts = [
        'name' => AsCollection::class,
        'description' => AsCollection::class,
        'active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Method $method) {
            $method->class = get_called_class();
        });
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
