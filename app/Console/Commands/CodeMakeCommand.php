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
    private $filesystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:code
    {model-name? : Specify an model class}
    {--clone= : Copy stubs to other directory}
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
        //Controller
        'app/Http/Controllers/stubs/controller.stub' => 'app/Http/Controllers/#studlyName#Controller.php',
        //Repository
        'app/Contracts/Repositories/stubs/repository.stub' => 'app/Contracts/Repositories/#studlyName#Repository.php',
        'app/Repositories/stubs/repository.stub' => 'app/Repositories/#studlyName#Repository.php',
        //Request
        'app/Http/Requests/stubs/create.stub' => 'app/Http/Requests/Create#studlyName#Post.php',
        'app/Http/Requests/stubs/update.stub' => 'app/Http/Requests/Update#studlyName#Post.php',
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
        'id', 'user_id', 'email_verified_at', 'remember_token', 'right', 'deleted_at', 'created_at', 'updated_at', 'password'
    ];

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
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

        $clone = $this->option('clone');

        if(empty($clone)) {
            if(empty($modelName)) {
                $this->generateCodes();
            } else {
                $this->generateCode($modelName);
            }
        } else {
            $this->copyTo($this->compileFiles, $clone);
            $this->copyTo($this->compileDetailFiles, $clone);
        }
    }

    protected function generateCodes() {
        $models = collect($this->filesystem->files(base_path($this->modelPath)))->filter(function ($item) {
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

        $this->studlyName = Str::studly(class_basename($className));
        $this->kebabStudlyName = Str::kebab($this->studlyName);
        $this->camelStudlyName = Str::camel($this->studlyName);
        $this->snakeStudlyName = Str::snake($this->studlyName);
        $this->pluralStudlyName = Str::plural($this->studlyName);
        $this->camelPluralStudlyName = Str::camel($this->pluralStudlyName);
        $this->snakePluralStudlyName = Str::snake($this->pluralStudlyName);

        if($this->option('check')) {
            $this->info("studlyName: " . $this->studlyName);
            $this->info("kebabStudlyName: " . $this->kebabStudlyName);
            $this->info("camelStudlyName: " . $this->camelStudlyName);
            $this->info("snakeStudlyName: " . $this->snakeStudlyName);
            $this->info("pluralStudlyName: " . $this->pluralStudlyName);
            $this->info("camelPluralStudlyName: " . $this->camelPluralStudlyName);
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
            $this->error("Class not exists: " . $class);
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
                $this->filesystem->delete($target);
            }

            foreach($this->compileFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                $this->filesystem->delete($target);
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
                if(!$this->filesystem->exists($target)) {
                    $content = $this->compileDetailFile($src, $columns);
                    $this->save($target, $content);
                }
            }

            foreach($this->compileFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                if(!$this->filesystem->exists($target)) {
                    $content = $this->compileFile($src, $columns);
                    $this->save($target, $content);
                }
            }
        }
        
        $this->updateComponentBootstrap([
            "require('./{$this->snakeStudlyName}/list');",
            "require('./{$this->snakeStudlyName}/create');",
            "require('./{$this->snakeStudlyName}/edit');",
        ]);

        $this->updateRoute([
            "Route::resource('/{$this->snakeStudlyName}', '{$this->studlyName}Controller');",
        ]);
    }

    protected function save($path, $content)
    {
        if(empty($content)) return;

        if (! $this->filesystem->isDirectory($directory = $this->filesystem->dirname($path))) {
            $this->filesystem->makeDirectory($directory, 0755, true);
        }

        $this->filesystem->put($path, $content);
    }

    protected function compileFile($path, $columns)
    {
        if(!$this->filesystem->exists($path)) {
            $this->error("File Not Exists: " . substr($path, strlen(base_path())));
            return "";
        }

        $name = basename($path, '.stub');

        $stub = $this->filesystem->get($path);

        $stub = $this->replaceModelName($stub);

        $subStubs = collect($this->filesystem->files(dirname($path)));

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

        if(!$this->filesystem->exists($path)) {
            $this->error("File Not Exists: " . substr($path, strlen(base_path())));
            return "";
        }

        $content = $this->filesystem->get($path);

        $outLine = "";

        foreach($columns as $column) {
            $columnTitle = $this->strTitle($column);

            $outLine .= str_replace(
                ['#ColumnName#', '#ColumnTitle#', '#studlyName#', '#kebabStudlyName#', '#camelStudlyName#', '#snakeStudlyName#', '#pluralStudlyName#', '#camelPluralStudlyName#', '#snakePluralStudlyName#'],
                [$column, $columnTitle, $this->studlyName, $this->kebabStudlyName, $this->camelStudlyName, $this->snakeStudlyName, $this->pluralStudlyName, $this->camelPluralStudlyName, $this->snakePluralStudlyName],
                $content
            ). "\n";
        }

        $outLine = trim($outLine, " \n");

        return $outLine;
    }

    protected function updateComponentBootstrap($lines)
    {
        $path = resource_path('js/components/bootstrap.js');

        $this->updateFile($path, $lines);
    }

    protected function updateRoute($lines)
    {
        $path = base_path('routes/web.php');

        $this->updateFile($path, $lines);
    }

    protected function updateFile($path, $lines)
    {
        if(!$this->filesystem->exists($path)) {
            $this->error("File Not Exists: " . substr($path, strlen(base_path())));
            return "";
        }

        if($this->option('check')) {
            $this->info("update: " . substr($path, strlen(base_path())));
            return "";
        }

        $content = $this->filesystem->get($path);

        if(!Str::endsWith($content, "\n")) {
            $this->filesystem->append($path, "\n");
        }

        foreach($lines as $line) {
            if(!Str::contains($content, $line)) {
                $this->filesystem->append($path, "$line\n");
            }
        }
    }

    private function strTitle($str) {
        return ucwords(str_replace("_", " ", $str));
    }

    private function replaceModelName($stub)
    {
        return str_replace(
            ['#studlyName#', '#kebabStudlyName#', '#camelStudlyName#', '#snakeStudlyName#', '#pluralStudlyName#', '#camelPluralStudlyName#', '#snakePluralStudlyName#'],
            [$this->studlyName, $this->kebabStudlyName, $this->camelStudlyName, $this->snakeStudlyName, $this->pluralStudlyName, $this->camelPluralStudlyName, $this->snakePluralStudlyName],
            $stub
        );
    }

    private function copyTo($compileFiles, $dir)
    {
        $targetDir = realpath($dir);

        if(Str::startsWith($targetDir, base_path())) {
            $this->error("can't copy to $dir");
            return;
        }

        foreach($compileFiles as $stub=>$compiledFile) {

            $stubs = $this->filesystem->files(dirname($stub));

            foreach($stubs as $stub){
                $rel = $stub->getRelativePathName();
                $src = base_path($stub);
                $target = $this->combinePath($targetDir, $stub);

                if($this->filesystem->exists($src) && ($this->option('force') || !$this->filesystem->exists($target))) {

                    if (! $this->filesystem->isDirectory($directory = $this->filesystem->dirname($target))) {
                        $this->filesystem->makeDirectory($directory, 0755, true);
                    }
    
                    $this->filesystem->copy($src, $target);
                    $this->info($stub);
                }
            }
        }
    }

    private function combinePath($targetDir, $path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            $targetDir, $path,
        ]);
    }
}
