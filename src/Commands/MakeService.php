<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Commands;

final class MakeService extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';
}
