<?php

namespace IBroStudio\PaymentMethodManager;

use Filament\Contracts\Plugin;
use Filament\Panel;

class PaymentMethodManagerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'payment-method-manager';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->discoverClusters(
                in: __DIR__ . '/Filament/Clusters',
                for: 'IBroStudio\\PaymentMethodManager\\Filament\\Clusters'
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
