<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CodeMakeCommand extends Command
{
    private $modelPath, $modelNamespace;
    private $studlyName, $snakeStudlyName, $pluralStudlyName, $snakePluralStudlyName;
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $file;

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
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $file)
    {
        parent::__construct();

        $this->file = $file;
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
        $models = collect(\File::allFiles(base_path($this->modelPath)))->filter(function ($model) {
            $rel = $model->getRelativePathName();
            return !strrpos($rel, '/');
        });

        foreach($models as $model) {
            $rel = $model->getRelativePathName();
            $modelName =  rtrim($rel, '.php');

            $this->generateCode($modelName);
        }
    }

    protected function generateCode($className) {

        $this->studlyName = Str::studly(class_basename($className));
        $this->snakeStudlyName = Str::snake($this->studlyName);
        $this->pluralStudlyName = Str::plural($this->studlyName);
        $this->snakePluralStudlyName = Str::snake($this->pluralStudlyName);

        $this->info("studlyName: " . $this->studlyName);
        $this->info("snakeStudlyName: " . $this->snakeStudlyName);
        $this->info("pluralStudlyName: " . $this->pluralStudlyName);
        $this->info("snakePluralStudlyName: " . $this->snakePluralStudlyName);

        $class = $this->modelNamespace . '\\' . $this->studlyName;

        if (class_exists($class)) {
            $obj = new $class();
            $tableName = $obj->getTable();
            $columns = Schema::getColumnListing($tableName);

            $this->createView($columns);

        } else {
            $this->error("Model not exists: " . $class);
        }
    }

    protected function createView($columns) {

        if (! is_dir($directory = $this->getViewPath($this->snakeStudlyName))) {
            mkdir($directory, 0755, true);
        }

        $modelViewPath = $this->getViewPath($this->snakeStudlyName . ".blade.php");
        $createViewPath = $this->getViewPath($this->snakeStudlyName . "/create.blade.php");
        $editViewPath = $this->getViewPath($this->snakeStudlyName . "/edit.blade.php");
        $showViewPath = $this->getViewPath($this->snakeStudlyName . "/show.blade.php");
        $createFormViewPath = $this->getViewPath($this->snakeStudlyName . "/create-form.blade.php");
        $editFormViewPath = $this->getViewPath($this->snakeStudlyName . "/edit-form.blade.php");

        $modelView = $this->buildView('model', $columns);
        $createView = $this->buildView('create', $columns);
        $editView = $this->buildView('edit', $columns);
        $showView = $this->buildView('show', $columns);
        $createFormView = $this->buildDetailView('create-form', $columns);
        $editFormView = $this->buildDetailView('edit-form', $columns);

        
        $this->save($modelViewPath, $modelView);
        $this->save($createViewPath, $createView);
        $this->save($editViewPath, $editView);
        $this->save($showViewPath, $showView);
        $this->save($createFormViewPath, $createFormView);
        $this->save($editFormViewPath, $editFormView);
    }

    protected function save($path, $content)
    {
        if(empty($content)) return;

        if($this->option('force')) {
            $this->file->put($path, $content);
        } else {
            if(!file_exists($path)) {
                $this->file->put($path, $content);
            }
        }
    }

    protected function getViewStub($viewStubName)
    {
        return $this->getViewPath("stubs/$viewStubName");
    }

    protected function buildView($name, $columns)
    {
        $path = $this->getViewStub("$name.stub");

        if(!file_exists($path)) {
            $this->error("File Not Exists: " . substr($path, strlen(base_path())));
            return "";
        }

        $stub = $this->file->get($path);

        $stub = $this->replaceModelName($stub);

        $subStubs = collect(\File::allFiles($this->getViewPath('stubs/')));

        foreach($subStubs as $subStub){
            $rel = $subStub->getRelativePathName();

            if(Str::startsWith($rel, "$name.") && $rel !== "$name.stub") {
                $subStubName = rtrim($rel, '.stub');

                $line = $this->buildDetailView($subStubName, $columns);

                $stub = str_replace(
                    ["#$subStubName#"],
                    [$line],
                    $stub
                );
            }
        }

        return $stub;
    }

    protected function buildDetailView($name, $columns) {
        $path = $this->getViewStub("$name.stub");

        if(!file_exists($path)) {
            $this->error("File Not Exists: " . substr($path, strlen(base_path())));
            return "";
        }

        $content = $this->file->get($path);

        $outLine = "";

        foreach($columns as $column) {
            $columnTitle = $this->strTitle($column);

            $outLine .= str_replace(
                ['#ColumnName#', '#ColumnTitle#', '#studlyName#', '#snakeStudlyName#', '#pluralStudlyName#', '#snakePluralStudlyName#'],
                [$column, $columnTitle, $this->studlyName, $this->snakeStudlyName, $this->pluralStudlyName, $this->snakePluralStudlyName],
                $content
            ). "\n";
        }

        $outLine = rtrim($outLine, " \n");

        return $outLine;
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

    private function strTitle($str) {
        return ucwords(str_replace("_", " ", $str));
    }

    private function replaceModelName($stub)
    {
        return str_replace(
            ['#studlyName#', '#snakeStudlyName#', '#pluralStudlyName#', '#snakePluralStudlyName#'],
            [$this->studlyName, $this->snakeStudlyName, $this->pluralStudlyName, $this->snakePluralStudlyName],
            $stub
        );
    }
}
