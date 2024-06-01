<?php

namespace Vix\LaravelUtils\Providers;

use Illuminate\Support\ServiceProvider;
use Vix\LaravelUtils\Commands\AuthGenerate;
use Vix\LaravelUtils\Commands\MakeHelper;
use Vix\LaravelUtils\Commands\MakeInterface;
use Vix\LaravelUtils\Commands\MakeService;
use Vix\LaravelUtils\Commands\MakeTrait;

class UtilsProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            AuthGenerate::class,
            MakeHelper::class,
            MakeInterface::class,
            MakeService::class,
            MakeTrait::class
        ]);
    }

    public function boot()
    {
        // Any additional boot logic here
    }
}