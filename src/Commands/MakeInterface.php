<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Commands;

final class MakeInterface extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name : The name of the interface}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new interface.';
}
