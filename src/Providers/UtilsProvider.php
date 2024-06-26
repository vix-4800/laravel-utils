<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
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
use Vix\LaravelUtils\Rules\Domain;
use Vix\LaravelUtils\Rules\PhoneNumber;
use App\Models\User;
use Vix\LaravelUtils\Traits\CanBeAdmin;
use Vix\LaravelUtils\Traits\CanBeBlocked;

final class UtilsProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeHelper::class,
                MakeInterface::class,
                MakeService::class,
                MakeTrait::class,
                MakeEnum::class,
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerBladeDirectives();
        $this->registerRules();

        if ($this->app->runningInConsole()) {
            $this->registerPublishes();
        }

        $this->registerGates();
    }

    /**
     * Register the blade directives.
     *
     * @return void
     */
    protected function registerBladeDirectives(): void
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

        Blade::directive('currency', function (string $expression): string {
            return $this->currencyDirective($expression);
        });

        Blade::directive('filesize', function (string $expression): string {
            return $this->filesizeDirective($expression);
        });

        Blade::directive('truncate', function (string $expression): string {
            return $this->truncateDirective($expression);
        });
    }

    /**
     * Register the publishable files.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../Commands/stubs' => base_path('resources/stubs'),
        ], 'stubs');
    }

    /**
     * Register the validation rules.
     *
     * @return void
     */
    protected function registerRules(): void
    {
        $this->app['validator']->extend('phone_number', function ($attribute, $value, $parameters, $validator) {
            return (new PhoneNumber)->passes($attribute, $value);
        });

        $this->app['validator']->extend('domain', function ($attribute, $value, $parameters, $validator) {
            return (new Domain)->passes($attribute, $value);
        });
    }

    /**
     * Register the gates.
     *
     * @return void
     */
    protected function registerGates(): void
    {
        Gate::define('admin', function (User $user) {
            if (in_array(CanBeAdmin::class, class_uses($user))) {
                return $user->isAdmin();
            }

            return $user->is_admin;
        });

        Gate::define('blocked', function (User $user) {
            if (in_array(CanBeBlocked::class, class_uses($user))) {
                return $user->isBlocked();
            }

            return false;
        });
    }

    /**
     * Currency directive.
     * Formats a number as a currency.
     * 
     * @param string $expression
     * @return string
     * 
     * @throws InvalidArgumentException
     */
    private function currencyDirective(string $expression): string
    {
        $arguments = explode(',', $expression);

        if (empty($arguments) || count($arguments) > 2) {
            throw new InvalidArgumentException('The @currency directive expects one or two arguments: amount and optional currency.');
        }

        $amount = (float) trim($arguments[0]);
        $currency = isset($arguments[1]) ? Currency::from(trim($arguments[1])) : Currency::USD;

        return "<?php echo $currency->value . number_format($amount, 2); ?>";
    }

    /**
     * Filesize directive.
     * Formats a number as a file size.
     * 
     * @param string $expression
     * @return string
     * 
     * @throws InvalidArgumentException
     */
    private function filesizeDirective(string $expression): string
    {
        $bytes = trim($expression);

        if (!is_numeric($bytes)) {
            throw new InvalidArgumentException('The @filesize directive expects a numeric value for the file size in bytes.');
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB'];
        $log = log((float) $bytes, 1024);
        $size = pow(1024, floor($log));
        $unitIndex = min(count($units) - 1, (int) floor($log / 10));

        return "<?php echo number_format($size, 2) . ' ' . $units[$unitIndex]; ?>";
    }

    /**
     * Truncate directive.
     * Truncates a string with an ellipsis.
     *
     * @param string $expression
     * @return string Truncated string
     * 
     * @throws InvalidArgumentException
     */
    private function truncateDirective(string $expression): string
    {
        $arguments = explode(',', $expression);

        if (empty($arguments) || count($arguments) > 2) {
            throw new InvalidArgumentException('The @truncate directive expects one or two arguments: length and optional ellipsis.');
        }

        $length = (int) trim($arguments[0]);
        $ellipsis = isset($arguments[1]) ? trim($arguments[1]) : '...';

        return "<?php echo Str::limit($arguments[0], $length, $ellipsis); ?>";
    }
}
