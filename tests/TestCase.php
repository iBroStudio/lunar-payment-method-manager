<?php

namespace IBroStudio\PaymentMethodManager\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use IBroStudio\DataRepository\Commands\DataRepositoryInstallCommand;
use IBroStudio\DataRepository\DataRepositoryServiceProvider;
use IBroStudio\PaymentMethodManager\PaymentMethodManagerServiceProvider;
use IBroStudio\TestSupport\Testing\Concerns\LunarTestCase;
use IBroStudio\TestSupport\TestSupportServiceProvider;
use IBroStudio\User\Commands\UserInstallCommand;
use IBroStudio\User\UserServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Artisan;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    use LunarTestCase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'IBroStudio\\PaymentMethodManager\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        static::lunarSetUp();

        Artisan::call(UserInstallCommand::class);
        Artisan::call(DataRepositoryInstallCommand::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            ...static::lunarPackageProviders(),
            PaymentMethodManagerServiceProvider::class,
            DataRepositoryServiceProvider::class,
            LaravelDataServiceProvider::class,
            UserServiceProvider::class,
            TestSupportServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__ . '/../database/migrations/2024_12_05_061824_create_payment_method_manager_tables.php';
        $migration->up();

        $migration = include __DIR__ . '/../database/migrations/2024_12_05_061933_create_payment_intents_table.php';
        $migration->up();
    }
}
