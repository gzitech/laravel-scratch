<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
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
    {--d|delete : Delete all files base on rules}
    {--f|force : Overwrite existing code by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold code for you base on models';

    /**
     * use $this->compileFile() to compile.
     */
    protected $compileFiles = [
        //views
        'resources/views/stubs/model.stub' => 'resources/views/#snakeStudlyName#.blade.php',
        'resources/views/stubs/show.stub' => 'resources/views/#snakeStudlyName#/show.blade.php',
        'resources/views/stubs/create.stub' => 'resources/views/#snakeStudlyName#/create.blade.php',
        'resources/views/stubs/edit.stub' => 'resources/views/#snakeStudlyName#/edit.blade.php',
        //JS
        'resources/js/stubs/ssky/list.stub' => 'resources/js/ssky/#snakeStudlyName#/list.js',
        'resources/js/stubs/ssky/create.stub' => 'resources/js/ssky/#snakeStudlyName#/create.js',
        'resources/js/stubs/ssky/edit.stub' => 'resources/js/ssky/#snakeStudlyName#/edit.js',
        'resources/js/stubs/components/list.stub' => 'resources/js/components/#snakeStudlyName#/list.js',
        'resources/js/stubs/components/create.stub' => 'resources/js/components/#snakeStudlyName#/create.js',
        'resources/js/stubs/components/edit.stub' => 'resources/js/components/#snakeStudlyName#/edit.js',
    ];

    /**
     * use $this->compileDetailFile() to compile.
     */
    protected $compileDetailFiles = [
        //views
        'resources/views/stubs/create-form.stub' => 'resources/views/#snakeStudlyName#/create-form.blade.php',
        'resources/views/stubs/edit-form.stub' => 'resources/views/#snakeStudlyName#/edit-form.blade.php',
    ];

    protected $ignoreFieldNames = [
        'id', 'email_verified_at', 'remember_token', 'right', 'deleted_at', 'created_at', 'updated_at', 'password'
    ];

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

        if($this->option('check')) {
            $this->info("studlyName: " . $this->studlyName);
            $this->info("snakeStudlyName: " . $this->snakeStudlyName);
            $this->info("pluralStudlyName: " . $this->pluralStudlyName);
            $this->info("snakePluralStudlyName: " . $this->snakePluralStudlyName);
        }

        $class = $this->modelNamespace . '\\' . $this->studlyName;

        if (class_exists($class)) {
            $obj = new $class();
            $tableName = $obj->getTable();
            $columns = Schema::getColumnListing($tableName);

            $columns = array_diff($columns, $this->ignoreFieldNames);

            $this->generateFile($columns);

        } else {
            $this->error("Model not exists: " . $class);
        }
    }

    protected function generateFile($columns) {

        if($this->option('check')) {
            $this->info("will create:");

            foreach($this->compileDetailFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $this->info("$target");
            }

            foreach($this->compileFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $this->info("$target");
            }

            return "";
        }

        if($this->option('delete')) {

            foreach($this->compileDetailFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $this->file->delete($target);
            }

            foreach($this->compileFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $this->file->delete($target);
            }

            return "";
        }

        if($this->option('force')) {

            foreach($this->compileDetailFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $content = $this->compileDetailFile($src, $columns);
                $this->save($target, $content);
            }

            foreach($this->compileFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $content = $this->compileFile($src, $columns);
                $this->save($target, $content);
            }

        } else {
            foreach($this->compileDetailFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                if(!file_exists($target)) {
                    $content = $this->compileDetailFile($src, $columns);
                    $this->save($target, $content);
                }
            }

            foreach($this->compileFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                if(!file_exists($target)) {
                    $content = $this->compileFile($src, $columns);
                    $this->save($target, $content);
                }
            }
        }
        
        $this->updateComponentBootstrap([
            "require('./$this->snakeStudlyName/list');",
            "require('./$this->snakeStudlyName/create');",
            "require('./$this->snakeStudlyName/edit');",
        ]);
    }

    protected function save($path, $content)
    {
        if(empty($content)) return;

        if (! is_dir($directory = dirname($path))) {
            mkdir($directory, 0755, true);
        }

        $this->file->put($path, $content);
    }

    protected function compileFile($path, $columns)
    {
        if(!file_exists($path)) {
            $this->error("File Not Exists: " . substr($path, strlen(base_path())));
            return "";
        }

        $name = basename($path, '.stub');

        $stub = $this->file->get($path);

        $stub = $this->replaceModelName($stub);

        $subStubs = collect(\File::allFiles(dirname($path)));

        foreach($subStubs as $subStub){
            $rel = $subStub->getRelativePathName();

            if(Str::startsWith($rel, "$name.") && $rel !== "$name.stub") {
                $subStubName = rtrim($rel, '.stub');

                $line = $this->compileDetailFile($subStub, $columns);

                $stub = str_replace(
                    ["#$subStubName#"],
                    [$line],
                    $stub
                );
            }
        }

        return $stub;
    }

    protected function compileDetailFile($path, $columns) {

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

        $outLine = trim($outLine, " \n");

        return $outLine;
    }

    protected function updateComponentBootstrap($lines)
    {
        $path = $this->getJsPath('components/bootstrap.js');

        if(!file_exists($path)) {
            $this->error("File Not Exists: " . substr($path, strlen(base_path())));
            return "";
        }

        if($this->option('check')) {
            $this->info("update: " . substr($path, strlen(base_path())));
            return "";
        }

        $content = $this->file->get($path);

        if(!Str::endsWith($content, "\n")) {
            $this->file->append($path, "\n");
        }

        foreach($lines as $line) {
            if(!Str::contains($content, $line)) {
                $this->file->append($path, "$line\n");
            }
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
