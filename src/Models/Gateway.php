<?php

namespace IBroStudio\PaymentMethodManager\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\PaymentMethodManager\Concerns;
use IBroStudio\PaymentMethodManager\Contracts\GatewayContract;
use IBroStudio\PaymentMethodManager\GatewayApi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gateway extends Model
{
    use Concerns\HasCredentialsComponentsForm;
    use HasDataRepository;

    public static string $gatewayData;

    public static string $gatewayApiAdapter;

    protected $table = 'payment_gateways';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'class',
        'credentials',
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
            'credentials' => DataObjectCast::class . (isset(static::$gatewayData) ? ':' . static::$gatewayData : ''),
        ];
    }

    public function getMorphClass()
    {
        return $this->class;
    }

    public function getChildModel(): GatewayContract | Gateway
    {
        if (get_parent_class($this) === Gateway::class) {
            return $this;
        }

        return $this->class::find($this->getKey());
    }

    public function methods(): HasMany
    {
        return $this->hasMany(Method::class, 'gateway_id');
    }

    public function api(): GatewayApi
    {
        $model = $this->getChildModel();

        return GatewayApi::use(
            driver: $model::$gatewayApiAdapter,
            parameters: $model->credentials->toArray()
        );
    }
}
