<?php

namespace Vix\LaravelUtils\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class MakeCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = Str::studly($this->argument('name'));
        $targetName = $this->getTargetName();

        $pluralTargetName = Str::plural($targetName);
        $path = app_path("{$pluralTargetName}/{$name}{$targetName}.php");

        if (File::exists($path)) {
            $this->error("{$targetName} {$name} already exists!");
            return 1;
        }

        $this->makeDirectory(dirname($path));

        $stub = File::get($this->getStub());
        $stub = str_replace("Dummy{$targetName}", "{$name}{$targetName}", $stub);

        File::put($path, $stub);

        $this->info("{$targetName} {$name} created successfully!");

        return 0;
    }

    /**
     * Get the target name.
     *
     * @return string
     */
    protected function getTargetName(): string
    {
        $reflect = new ReflectionClass($this);
        $className = $reflect->getShortName();

        return Str::replaceFirst('Make', '', $className);
    }

    /**
     * Get the stub file for the generation.
     *
     * @return string
     */
    abstract protected function getStub(): string;

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
