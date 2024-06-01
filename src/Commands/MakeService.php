<?php

namespace Vix\LaravelUtils\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeService extends Command
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

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = Str::studly($this->argument('name'));
        $path = app_path("Services/{$name}Service.php");

        if (File::exists($path)) {
            $this->error("Service {$name} already exists!");
            return 1;
        }

        $this->makeDirectory(dirname($path));

        $stub = File::get($this->getStub());
        $stub = str_replace('DummyService', "{$name}Service", $stub);

        File::put($path, $stub);

        $this->info("Service {$name} created successfully!");

        return 0;
    }

    /**
     * Get the stub file for the generation.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/service.stub';
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
