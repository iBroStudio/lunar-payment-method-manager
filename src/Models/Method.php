<?php

namespace IBroStudio\PaymentMethodManager\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Method extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

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
