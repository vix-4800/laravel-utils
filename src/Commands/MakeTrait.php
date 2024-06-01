<?php

declare(strict_types=1);

namespace Vix\LaravelUtils\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class MakeTrait extends Command
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
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $path = app_path("Traits/$name.php");

        if (File::exists($path)) {
            $this->error("Trait {$name} already exists!");
            return 1;
        }

        $this->makeDirectory(dirname($path));

        $stub = File::get($this->getStub());
        $stub = str_replace('DummyTrait', $name, $stub);

        File::put($path, $stub);

        $this->info("Trait {$name} created successfully.");

        return 0;
    }

    /**
     * Get the stub file for the generation.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/trait.stub';
    }

    /**
     * Create a directory if it doesn't exist.
     *
     * @param string $directory
     * @return void
     */
    protected function makeDirectory(string $directory)
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }
    }
}
