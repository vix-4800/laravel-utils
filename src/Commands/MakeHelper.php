<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Commands;

final class MakeHelper extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {name : The name of the helper}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new helper class';
}
