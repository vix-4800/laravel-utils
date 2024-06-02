<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Commands;

final class MakeEnum extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name : The name of the enum}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new enum';
}
