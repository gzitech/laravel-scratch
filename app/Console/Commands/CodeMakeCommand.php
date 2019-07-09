<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CodeMakeCommand extends Command
{
    private $modelPath, $modelNamespace;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:code
    {model-name? : Specify an model class}
    {--p|model-path=app : Specify model directory}
    {--s|model-namespace=App : Specify model namespace}
    {--c|check : Only show you what will create without write}
    {--f|force : Overwrite existing code by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold code for you base on models';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modelName = $this->argument('model-name');
        $this->modelPath = $this->option('model-path');
        $this->modelNamespace = $this->option('model-namespace');

        $this->createDirectories();

        if(empty($modelName)) {
            $this->generateCodes();
        } else {
            $this->generateCode($modelName);
        }
    }

    protected function generateCodes() {
        $models = collect(\File::allFiles(base_path($this->modelPath)))->filter(function ($item) {
            $rel = $item->getRelativePathName();
            return !strrpos($rel, '/');
        });

        foreach($models as $model) {
            $rel = $model->getRelativePathName();
            $modelName =  rtrim($rel, '.php');

            $this->generateCode($modelName);
        }
    }

    protected function generateCode($className) {

        $class = $this->modelNamespace . '\\' . $className;

        if (class_exists($class)) {
            $obj = new $class();

            $table = $obj->getTable();

            $cols = Schema::getColumnListing($table);

            echo "table: $table\n";

            print_r($cols);

            echo "\n";
        }
    }

    protected function createDirectories()
    {
        if (! is_dir($directory = $this->getViewPath('layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getJsPath('components'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getJsPath('ssky'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getSassPath(''))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getControllerPath(''))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getContractPath(''))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getRepositoryPath(''))) {
            mkdir($directory, 0755, true);
        }
    }

    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }

    protected function getJsPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            resource_path('js'), $path,
        ]);
    }

    protected function getSassPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            resource_path('sass'), $path,
        ]);
    }

    protected function getControllerPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            app_path('Http/Controllers'), $path,
        ]);
    }

    protected function getContractPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            app_path('Contracts/Repositories'), $path,
        ]);
    }

    protected function getRepositoryPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            app_path('Repositories'), $path,
        ]);
    }
}
