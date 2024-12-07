<?php

namespace IBroStudio\PaymentMethodManager\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\PanelManager\Forms\Concerns\HasTranslatableRadioDeck;
use IBroStudio\PanelManager\Forms\Contracts\RadioDeckableContract;
use IBroStudio\PaymentMethodManager\Concerns;
use IBroStudio\PaymentMethodManager\Contracts\MethodContract;
use IBroStudio\PaymentMethodManager\Enums\PaymentMethodStatesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Lunar\Base\PaymentTypeInterface;
use Lunar\Base\Traits\HasTranslations;
use Lunar\Models\Cart;
use Lunar\Models\Customer;

class Method extends Model implements PaymentTypeInterface, RadioDeckableContract
{
    use Concerns\CanManageCheckoutPayment;
    use Concerns\HasCredentialsComponentsForm;
    use HasDataRepository;
    use HasTranslatableRadioDeck;
    use HasTranslations;

    protected $table = 'payment_methods';

    public static string $dataClass;

    public static string $defaultIcon = 'lucide-credit-card';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'class',
        'gateway_id',
        'description',
        'icon',
        'customer_id',
        'state',
        'credentials',
        'default',
        'enabled',
    ];

    protected $radioDeckOption = [
        'key' => 'id',
        'label' => 'name',
        'description' => 'description',
    ];

    protected function radioDeckDescription(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->customer_id) ?
                $this->getChildModel()->credentials->presenter()->asOptionDescription() : $this->translate($this->radioDeckOption['description']),
        );
    }

    protected function casts(): array
    {
        return [
            'name' => AsCollection::class,
            'description' => AsCollection::class,
            'credentials' => DataObjectCast::class . (isset(static::$dataClass) ? ':' . static::$dataClass : ''),
            'state' => PaymentMethodStatesEnum::class,
            'default' => 'boolean',
            'enabled' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Method $method) {
            $method->class = get_called_class();
        });
    }

    public function getChildModel(): MethodContract | Method
    {
        if (get_parent_class($this) === Method::class) {
            return $this;
        }

        return $this->class::find($this->getKey());
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class, 'gateway_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function intents(): HasManyThrough
    {
        return $this->hasManyThrough(PaymentIntent::class, Cart::class);
    }

    public function scopeDefault(Builder $query): void
    {
        $query->where('default', 1);
    }

    public function scopeEnabled(Builder $query): void
    {
        $query->where('enabled', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('state', PaymentMethodStatesEnum::ACTIVE);
    }
}
