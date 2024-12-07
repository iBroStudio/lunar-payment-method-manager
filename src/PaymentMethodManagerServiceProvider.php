<?php

namespace IBroStudio\PaymentMethodManager;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use IBroStudio\PaymentMethodManager\Commands\PaymentMethodManagerCommand;
use IBroStudio\PaymentMethodManager\Models\Method;
use IBroStudio\PaymentMethodManager\Models\PaymentIntent;
use Illuminate\Filesystem\Filesystem;
use Lunar\Models\Cart;
use Lunar\Models\Customer;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PaymentMethodManagerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'lunar-payment-method-manager';

    public static string $viewNamespace = 'lunar-payment-method-manager';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasMigrations([
                '2024_12_05_061824_create_payment_method_manager_tables',
                '2024_12_05_061933_create_payment_intents_table',
            ])
            ->hasTranslations()
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('ibrostudio/lunar-payment-method-manager');
            });
        /*
                $configFileName = 'payment-method-manager';

                if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
                    $package->hasConfigFile();
                }

                if (file_exists($package->basePath('/../resources/views'))) {
                    $package->hasViews(static::$viewNamespace);
                }
        */
    }

    public function packageRegistered(): void
    {
        $this->app->bind(PaymentMethodManager::class, function ($app) {
            return new PaymentMethodManager;
        });

        $this->app->singleton(PaymentMethodRegistry::class, function () {
            return new PaymentMethodRegistry;
        });
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/lunar-payment-method-manager/{$file->getFilename()}"),
                ], 'lunar-payment-method-manager-stubs');
            }
        }

        Customer::resolveRelationUsing('paymentMethods', function (Customer $customer) {
            return $customer->hasMany(Method::class);
        });

        Customer::resolveRelationUsing('activePaymentMethods', function (Customer $customer) {
            return $customer->paymentMethods()->active();
        });

        Cart::resolveRelationUsing('paymentIntents', function (Cart $cart) {
            return $cart->hasMany(PaymentIntent::class);
        });
    }

    protected function getAssetPackageName(): ?string
    {
        return 'ibrostudio/lunar-payment-method-manager';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('lunar-payment-method-manager', __DIR__ . '/../resources/dist/components/lunar-payment-method-manager.js'),
            //Css::make('lunar-payment-method-manager-styles', __DIR__ . '/../resources/dist/lunar-payment-method-manager.css'),
            //Js::make('lunar-payment-method-manager-scripts', __DIR__ . '/../resources/dist/lunar-payment-method-manager.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            PaymentMethodManagerCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_lunar-payment-method-manager_table',
        ];
    }
}
