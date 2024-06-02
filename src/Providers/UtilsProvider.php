<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Providers;

use Illuminate\Support\ServiceProvider;
use Vix\LaravelUtils\Commands\MakeEnum;
use Vix\LaravelUtils\Commands\MakeHelper;
use Vix\LaravelUtils\Commands\MakeInterface;
use Vix\LaravelUtils\Commands\MakeService;
use Vix\LaravelUtils\Commands\MakeTrait;

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

    public function boot()
    {
        // Any additional boot logic here
    }
}
