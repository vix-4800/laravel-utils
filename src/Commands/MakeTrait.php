<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Commands;

use Illuminate\Support\Facades\File;

final class MakeTrait extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name : The name of the trait}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * Get the stub file for the generation.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/trait.stub';
    }
}
