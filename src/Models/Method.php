<?php

namespace IBroStudio\PaymentMethodManager\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Method extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    public $timestamps = false;

    protected $fillable = [
        'gateway_id',
        'name',
        'description',
        'icon',
        'enabled',
    ];

    protected $casts = [
        'name' => AsCollection::class,
        'description' => AsCollection::class,
        'enabled' => 'boolean',
    ];

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }
}
