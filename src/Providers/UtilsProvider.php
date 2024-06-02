<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Vix\LaravelUtils\Commands\{
    MakeEnum,
    MakeHelper,
    MakeInterface,
    MakeService,
    MakeTrait
};
use Vix\LaravelUtils\Enums\Currency;

final class UtilsProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            MakeHelper::class,
            MakeInterface::class,
            MakeService::class,
            MakeTrait::class,
            MakeEnum::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBladeDirectives();

    }

    /**
     * Register the blade directives.
     *
     * @return void
     */
    private function registerBladeDirectives()
    {
        Blade::directive('datetime', function (string $expression): string {
            return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
        });

        Blade::directive('date', function (string $expression): string {
            return "<?php echo ($expression)->format('m/d/Y'); ?>";
        });

        Blade::directive('time', function (string $expression): string {
            return "<?php echo ($expression)->format('H:i'); ?>";
        });

        Blade::directive('currency', function (string $expression) {
            $arguments = explode(',', $expression);

            if (empty($arguments) || count($arguments) > 2) {
                throw new InvalidArgumentException('The @currency directive expects one or two arguments: amount and optional currency.');
            }

            $amount = (float) trim($arguments[0]);
            $currency = isset($arguments[1]) ? Currency::from(trim($arguments[1])) : Currency::USD;

            return "<?php echo $currency->value . number_format($amount, 2); ?>";
        });
        // Any additional boot logic here
    }
}
