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

    protected $compileDetailFiles = [
        //views
        'resources/views/stubs/create-form.stub' => 'resources/views/#snakeStudlyName#/create-form.blade.php',
        'resources/views/stubs/edit-form.stub' => 'resources/views/#snakeStudlyName#/edit-form.blade.php',
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

            $this->generateFile($columns);

        } else {
            $this->error("Model not exists: " . $class);
        }
    }

    protected function generateFile($columns) {

        if($this->option('check')) {
            $this->info("will create:");
            foreach($this->compileFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $this->info("$target");
            }

            foreach($this->compileDetailFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $this->info("$target");
            }

            return "";
        }

        if($this->option('force')) {
            foreach($this->compileFiles as $src=>$target) {
                $content = $this->compileFile($src, $columns);
                $this->save($target, $content);
            }

            foreach($this->compileDetailFiles as $src=>$target) {
                $content = $this->compileDetailFile($src, $columns);
                $this->save($target, $content);
            }
        } else {
            foreach($this->compileFiles as $src=>$target) {
                if(!file_exists($target)) {
                    $content = $this->compileFile($src, $columns);
                    $this->save($target, $content);
                }
            }

            foreach($this->compileDetailFiles as $src=>$target) {
                if(!file_exists($target)) {
                    $content = $this->compileDetailFile($src, $columns);
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

    // protected function createView($columns) {

    //     if (! is_dir($directory = $this->getViewPath($this->snakeStudlyName))) {
    //         mkdir($directory, 0755, true);
    //     }

    //     $modelViewPath = $this->getViewPath($this->snakeStudlyName . ".blade.php");
    //     $createViewPath = $this->getViewPath($this->snakeStudlyName . "/create.blade.php");
    //     $editViewPath = $this->getViewPath($this->snakeStudlyName . "/edit.blade.php");
    //     $showViewPath = $this->getViewPath($this->snakeStudlyName . "/show.blade.php");
    //     $createFormViewPath = $this->getViewPath($this->snakeStudlyName . "/create-form.blade.php");
    //     $editFormViewPath = $this->getViewPath($this->snakeStudlyName . "/edit-form.blade.php");

    //     $modelView = $this->buildView('model', $columns);
    //     $createView = $this->buildView('create', $columns);
    //     $editView = $this->buildView('edit', $columns);
    //     $showView = $this->buildView('show', $columns);
    //     $createFormView = $this->buildDetailView('create-form', $columns);
    //     $editFormView = $this->buildDetailView('edit-form', $columns);

        
    //     $this->save($modelViewPath, $modelView);
    //     $this->save($createViewPath, $createView);
    //     $this->save($editViewPath, $editView);
    //     $this->save($showViewPath, $showView);
    //     $this->save($createFormViewPath, $createFormView);
    //     $this->save($editFormViewPath, $editFormView);
    // }

    // protected function createJs($columns) {
    //     if (! is_dir($directory = $this->getJsPath('ssky/' . $this->snakeStudlyName))) {
    //         mkdir($directory, 0755, true);
    //     }

    //     $listJsPath = $this->getJsPath('ssky/' . $this->snakeStudlyName . "/list.js");
    //     $createJsPath = $this->getJsPath('ssky/' . $this->snakeStudlyName . "/create.js");
    //     $editJsPath = $this->getJsPath('ssky/' . $this->snakeStudlyName . "/edit.js");

    //     $listJs = $this->buildJs('list', $columns);
    //     $createJs = $this->buildJs('create', $columns);
    //     $editJs = $this->buildJs('edit', $columns);

    //     $this->save($listJsPath, $listJs);
    //     $this->save($createJsPath, $createJs);
    //     $this->save($editJsPath, $editJs);

    //     if (! is_dir($directory = $this->getJsPath('components/' . $this->snakeStudlyName))) {
    //         mkdir($directory, 0755, true);
    //     }

    //     $listJsPath = $this->getJsPath('components/' . $this->snakeStudlyName . "/list.js");
    //     $createJsPath = $this->getJsPath('components/' . $this->snakeStudlyName . "/create.js");
    //     $editJsPath = $this->getJsPath('components/' . $this->snakeStudlyName . "/edit.js");

    //     $listJs = $this->buildComponent('list', $columns);
    //     $createJs = $this->buildComponent('create', $columns);
    //     $editJs = $this->buildComponent('edit', $columns);

    //     $this->save($listJsPath, $listJs);
    //     $this->save($createJsPath, $createJs);
    //     $this->save($editJsPath, $editJs);

    //     $this->updateComponentBootstrap([
    //         "require('./$this->snakeStudlyName/list');",
    //         "require('./$this->snakeStudlyName/create');",
    //         "require('./$this->snakeStudlyName/edit');",
    //     ]);
    // }

    protected function save($path, $content)
    {
        if(empty($content)) return;

        if (! is_dir($directory = dirname($path))) {
            mkdir($directory, 0755, true);
        }

        $this->file->put($path, $content);
    }

    // protected function getViewStub($viewStubName)
    // {
    //     return $this->getViewPath("stubs/$viewStubName");
    // }

    // protected function getJsStub($viewStubName)
    // {
    //     return $this->getJsPath("stubs/$viewStubName");
    // }

    // protected function buildView($name, $columns)
    // {
    //     $path = $this->getViewStub("$name.stub");

    //     return $this->buildFile($name, $path, $columns);
    // }

    // protected function buildDetailView($name, $columns) {
    //     $path = $this->getViewStub("$name.stub");
    //     return $this->buildDetailFile($name, $path, $columns);
    // }

    // protected function buildJs($name, $columns)
    // {
    //     $path = $this->getJsStub("$name.stub");
    //     return $this->buildFile($name, $path, $columns);
    // }

    // protected function buildDetailJs($name, $columns) {
    //     $path = $this->getJsStub("$name.stub");
    //     return $this->buildDetailFile($name, $path, $columns);
    // }

    // protected function buildComponent($name, $columns)
    // {
    //     $path = $this->getJsStub("component.stub");
    //     return $this->buildFile($name, $path, $columns);
    // }

    protected function compileFile($path, $columns)
    {
        if(!file_exists($path)) {
            $this->error("File Not Exists: " . substr($path, strlen(base_path())));
            return "";
        }

        $name = basename($path, '.stub');

        $this->info($name);
        return;

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
