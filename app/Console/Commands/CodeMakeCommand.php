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
    private $modelName, $snakeModelName, $tableName, $snakeTableName;
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
    protected $description = 'Create scaffold code base on models';

    protected $baseFiles = [
        // command
        'app/Console/Commands/CodeMakeCommand.php' => 'app/Console/Commands/CodeMakeCommand.php',
        // contracts
        'app/Contracts/Repositories/RoleRepository.php' => 'app/Contracts/Repositories/RoleRepository.php',
        'app/Contracts/Repositories/SiteRepository.php' => 'app/Contracts/Repositories/SiteRepository.php',
        'app/Contracts/Repositories/UserRepository.php' => 'app/Contracts/Repositories/UserRepository.php',
        // repositories
        'app/Repositories/RoleRepository.php' => 'app/Repositories/RoleRepository.php',
        'app/Repositories/SiteRepository.php' => 'app/Repositories/SiteRepository.php',
        'app/Repositories/UserRepository.php' => 'app/Repositories/UserRepository.php',
        // model
        'app/Role.php' => 'app/Role.php',
        'app/Site.php' => 'app/Site.php',
        'app/SiteUrl.php' => 'app/SiteUrl.php',
        'app/User.php' => 'app/User.php',
        // middleware
        'app/Http/Middleware/CheckForSubSite.php' => 'app/Http/Middleware/CheckForSubSite.php',
        // kernel
        'app/Http/Kernel.php' => 'app/Http/Kernel.php',
        // controller
        'app/Http/Controllers/Auth/ForgotPasswordController.php' => 'app/Http/Controllers/Auth/ForgotPasswordController.php',
        'app/Http/Controllers/Auth/LoginController.php' => 'app/Http/Controllers/Auth/LoginController.php',
        'app/Http/Controllers/Auth/RegisterController.php' => 'app/Http/Controllers/Auth/RegisterController.php',
        'app/Http/Controllers/Auth/ResetPasswordController.php' => 'app/Http/Controllers/Auth/ResetPasswordController.php',
        'app/Http/Controllers/Auth/VerificationController.php' => 'app/Http/Controllers/Auth/VerificationController.php',
        'app/Http/Controllers/Controller.php' => 'app/Http/Controllers/Controller.php',
        'app/Http/Controllers/HomeController.php' => 'app/Http/Controllers/HomeController.php',
        'app/Http/Controllers/RightController.php' => 'app/Http/Controllers/RightController.php',
        'app/Http/Controllers/RoleController.php' => 'app/Http/Controllers/RoleController.php',
        'app/Http/Controllers/Setting/ProfileController.php' => 'app/Http/Controllers/Setting/ProfileController.php',
        'app/Http/Controllers/Setting/SecurityController.php' => 'app/Http/Controllers/Setting/SecurityController.php',
        'app/Http/Controllers/SiteController.php' => 'app/Http/Controllers/SiteController.php',
        'app/Http/Controllers/SiteUrlController.php' => 'app/Http/Controllers/SiteUrlController.php',
        'app/Http/Controllers/UserController.php' => 'app/Http/Controllers/UserController.php',
        // Requests
        'app/Http/Requests/CreateRolePost.php' => 'app/Http/Requests/CreateRolePost.php',
        'app/Http/Requests/CreateSitePost.php' => 'app/Http/Requests/CreateSitePost.php',
        'app/Http/Requests/CreateUserPost.php' => 'app/Http/Requests/CreateUserPost.php',
        'app/Http/Requests/UpdateRolePost.php' => 'app/Http/Requests/UpdateRolePost.php',
        'app/Http/Requests/UpdateUserPost.php' => 'app/Http/Requests/UpdateUserPost.php',
        // AppServiceProvider
        'app/Providers/AppServiceProvider.php' => 'app/Providers/AppServiceProvider.php',
        // routes
        'routes/web.php' => 'routes/web.php',
        // config
        'config/database.php' => 'config/database.php',
        'config/rbac.php' => 'config/rbac.php',
        'config/site.php' => 'config/site.php',
        'config/app.php' => 'config/app.php',
        // migrations
        'database/migrations/2014_10_12_000000_create_users_table.php' => 'database/migrations/2014_10_12_000000_create_users_table.php',
        'database/migrations/2014_10_12_100000_create_password_resets_table.php' => 'database/migrations/2014_10_12_100000_create_password_resets_table.php',
        'database/migrations/2019_07_08_044501_create_sites_table.php' => 'database/migrations/2019_07_08_044501_create_sites_table.php',
        'database/migrations/2019_07_08_045952_create_site_user_table.php' => 'database/migrations/2019_07_08_045952_create_site_user_table.php',
        'database/migrations/2019_07_08_052428_create_site_urls_table.php' => 'database/migrations/2019_07_08_052428_create_site_urls_table.php',
        'database/migrations/2019_07_09_030458_create_roles_table.php' => 'database/migrations/2019_07_09_030458_create_roles_table.php',
        'database/migrations/2019_07_09_030954_create_role_user_table.php' => 'database/migrations/2019_07_09_030954_create_role_user_table.php',
        // seeds
        'database/seeds/DatabaseSeeder.php' => 'database/seeds/DatabaseSeeder.php',
        'database/seeds/RolesTableSeeder.php' => 'database/seeds/RolesTableSeeder.php',
        'database/seeds/UsersTableSeeder.php' => 'database/seeds/UsersTableSeeder.php',
        // scss
        'resources/sass/_custom.scss' => 'resources/sass/_custom.scss',
        'resources/sass/_variables.scss' => 'resources/sass/_variables.scss',
        'resources/sass/app.scss' => 'resources/sass/app.scss',
        'resources/sass/components/_buttons.scss' => 'resources/sass/components/_buttons.scss',
        'resources/sass/components/_cards.scss' => 'resources/sass/components/_cards.scss',
        'resources/sass/components/_dropdown.scss' => 'resources/sass/components/_dropdown.scss',
        'resources/sass/components/_metrics.scss' => 'resources/sass/components/_metrics.scss',
        'resources/sass/components/_modals.scss' => 'resources/sass/components/_modals.scss',
        'resources/sass/components/_navbar.scss' => 'resources/sass/components/_navbar.scss',
        'resources/sass/components/_notifications.scss' => 'resources/sass/components/_notifications.scss',
        'resources/sass/components/_team-member-list.scss' => 'resources/sass/components/_team-member-list.scss',
        'resources/sass/components/_uploader.scss' => 'resources/sass/components/_uploader.scss',
        'resources/sass/elements/_forms.scss' => 'resources/sass/elements/_forms.scss',
        'resources/sass/elements/_icons.scss' => 'resources/sass/elements/_icons.scss',
        'resources/sass/elements/_tables.scss' => 'resources/sass/elements/_tables.scss',
        'resources/sass/elements/_text.scss' => 'resources/sass/elements/_text.scss',
        'resources/sass/elements/_utilities.scss' => 'resources/sass/elements/_utilities.scss',
        'resources/sass/img/radio-select-default.svg' => 'resources/sass/img/radio-select-default.svg',
        'resources/sass/img/radio-select-is-selected.svg' => 'resources/sass/img/radio-select-is-selected.svg',
        // js
        'resources/js/app.js' => 'resources/js/app.js',
        'resources/js/bootstrap.js' => 'resources/js/bootstrap.js',
        'resources/js/components/auth/login.js' => 'resources/js/components/auth/login.js',
        'resources/js/components/auth/register.js' => 'resources/js/components/auth/register.js',
        'resources/js/components/bootstrap.js' => 'resources/js/components/bootstrap.js',
        'resources/js/components/role/create.js' => 'resources/js/components/role/create.js',
        'resources/js/components/role/edit.js' => 'resources/js/components/role/edit.js',
        'resources/js/components/role/list.js' => 'resources/js/components/role/list.js',
        'resources/js/components/site/create.js' => 'resources/js/components/site/create.js',
        'resources/js/components/site/list.js' => 'resources/js/components/site/list.js',
        'resources/js/components/user/create.js' => 'resources/js/components/user/create.js',
        'resources/js/components/user/edit.js' => 'resources/js/components/user/edit.js',
        'resources/js/components/user/list.js' => 'resources/js/components/user/list.js',
        'resources/js/none.js' => 'resources/js/none.js',
        'resources/js/ssky/auth/login.js' => 'resources/js/ssky/auth/login.js',
        'resources/js/ssky/auth/register.js' => 'resources/js/ssky/auth/register.js',
        'resources/js/ssky/form/bootstrap.js' => 'resources/js/ssky/form/bootstrap.js',
        'resources/js/ssky/form/errors.js' => 'resources/js/ssky/form/errors.js',
        'resources/js/ssky/form/form.js' => 'resources/js/ssky/form/form.js',
        'resources/js/ssky/form/http.js' => 'resources/js/ssky/form/http.js',
        'resources/js/ssky/form/rule.js' => 'resources/js/ssky/form/rule.js',
        'resources/js/ssky/role/create.js' => 'resources/js/ssky/role/create.js',
        'resources/js/ssky/role/edit.js' => 'resources/js/ssky/role/edit.js',
        'resources/js/ssky/role/list.js' => 'resources/js/ssky/role/list.js',
        'resources/js/ssky/site/create.js' => 'resources/js/ssky/site/create.js',
        'resources/js/ssky/site/list.js' => 'resources/js/ssky/site/list.js',
        'resources/js/ssky/ssky-bootstrap.js' => 'resources/js/ssky/ssky-bootstrap.js',
        'resources/js/ssky/ssky.js' => 'resources/js/ssky/ssky.js',
        'resources/js/ssky/user/create.js' => 'resources/js/ssky/user/create.js',
        'resources/js/ssky/user/edit.js' => 'resources/js/ssky/user/edit.js',
        'resources/js/ssky/user/list.js' => 'resources/js/ssky/user/list.js',
        'resources/js/ssky/vue-bootstrap.js' => 'resources/js/ssky/vue-bootstrap.js',
        // view
        'resources/views/auth/login.blade.php' => 'resources/views/auth/login.blade.php',
        'resources/views/auth/passwords/email.blade.php' => 'resources/views/auth/passwords/email.blade.php',
        'resources/views/auth/passwords/reset.blade.php' => 'resources/views/auth/passwords/reset.blade.php',
        'resources/views/auth/register.blade.php' => 'resources/views/auth/register.blade.php',
        'resources/views/auth/verify.blade.php' => 'resources/views/auth/verify.blade.php',
        'resources/views/home.blade.php' => 'resources/views/home.blade.php',
        'resources/views/layouts/app.blade.php' => 'resources/views/layouts/app.blade.php',
        'resources/views/nav/guest.blade.php' => 'resources/views/nav/guest.blade.php',
        'resources/views/nav/left.blade.php' => 'resources/views/nav/left.blade.php',
        'resources/views/nav/search.blade.php' => 'resources/views/nav/search.blade.php',
        'resources/views/nav/setting.blade.php' => 'resources/views/nav/setting.blade.php',
        'resources/views/nav/user.blade.php' => 'resources/views/nav/user.blade.php',
        'resources/views/right.blade.php' => 'resources/views/right.blade.php',
        'resources/views/role/create-form.blade.php' => 'resources/views/role/create-form.blade.php',
        'resources/views/role/create.blade.php' => 'resources/views/role/create.blade.php',
        'resources/views/role/edit-form.blade.php' => 'resources/views/role/edit-form.blade.php',
        'resources/views/role/edit.blade.php' => 'resources/views/role/edit.blade.php',
        'resources/views/role/show.blade.php' => 'resources/views/role/show.blade.php',
        'resources/views/role.blade.php' => 'resources/views/role.blade.php',
        'resources/views/setting/profile/edit-form.blade.php' => 'resources/views/setting/profile/edit-form.blade.php',
        'resources/views/setting/profile.blade.php' => 'resources/views/setting/profile.blade.php',
        'resources/views/setting/security/edit-form.blade.php' => 'resources/views/setting/security/edit-form.blade.php',
        'resources/views/setting/security.blade.php' => 'resources/views/setting/security.blade.php',
        'resources/views/site/create-form.blade.php' => 'resources/views/site/create-form.blade.php',
        'resources/views/site/create.blade.php' => 'resources/views/site/create.blade.php',
        'resources/views/site/show.blade.php' => 'resources/views/site/show.blade.php',
        'resources/views/site.blade.php' => 'resources/views/site.blade.php',
        'resources/views/user/create-form.blade.php' => 'resources/views/user/create-form.blade.php',
        'resources/views/user/create.blade.php' => 'resources/views/user/create.blade.php',
        'resources/views/user/edit-form.blade.php' => 'resources/views/user/edit-form.blade.php',
        'resources/views/user/edit.blade.php' => 'resources/views/user/edit.blade.php',
        'resources/views/user/show.blade.php' => 'resources/views/user/show.blade.php',
        'resources/views/user.blade.php' => 'resources/views/user.blade.php',
        'webpack.mix.js' => 'webpack.mix.js',
        'package.json' => 'package.json',
    ];

    /**
     * use $this->compileFile() to compile.
     */
    protected $compileFiles = [
        //views
        'resources/views/stubs/model.stub' => 'resources/views/#url#.blade.php',
        'resources/views/stubs/show.stub' => 'resources/views/#url#/show.blade.php',
        'resources/views/stubs/create.stub' => 'resources/views/#url#/create.blade.php',
        'resources/views/stubs/edit.stub' => 'resources/views/#url#/edit.blade.php',
        //JS
        'resources/js/stubs/ssky/list.stub' => 'resources/js/ssky/#url#/list.js',
        'resources/js/stubs/ssky/create.stub' => 'resources/js/ssky/#url#/create.js',
        'resources/js/stubs/ssky/edit.stub' => 'resources/js/ssky/#url#/edit.js',
        'resources/js/stubs/components/list.stub' => 'resources/js/components/#url#/list.js',
        'resources/js/stubs/components/create.stub' => 'resources/js/components/#url#/create.js',
        'resources/js/stubs/components/edit.stub' => 'resources/js/components/#url#/edit.js',
        //Controller
        'app/Http/Controllers/stubs/controller.stub' => 'app/Http/Controllers/#modelName#Controller.php',
        //Repository
        'app/Contracts/Repositories/stubs/repository.stub' => 'app/Contracts/Repositories/#modelName#Repository.php',
        'app/Repositories/stubs/repository.stub' => 'app/Repositories/#modelName#Repository.php',
        //Request
        'app/Http/Requests/stubs/create.stub' => 'app/Http/Requests/Create#modelName#Post.php',
        'app/Http/Requests/stubs/update.stub' => 'app/Http/Requests/Update#modelName#Post.php',
    ];

    /**
     * use $this->compileDetailFile() to compile.
     */
    protected $compileDetailFiles = [
        //views
        'resources/views/stubs/create-form.stub' => 'resources/views/#url#/create-form.blade.php',
        'resources/views/stubs/edit-form.stub' => 'resources/views/#url#/edit-form.blade.php',
    ];

    protected $ignoreFieldNames = [
        'id', 'user_id', 'mass_message_id', 'email_verified_at', 'remember_token', 'right', 'deleted_at', 'created_at', 'updated_at', 'password'
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
            $this->copyTo($this->baseFiles, $clone);
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

        $this->modelName = Str::studly(class_basename($className));
        $this->kebabModelName = Str::kebab($this->modelName);
        $this->camelModelName = Str::camel($this->modelName);
        $this->snakeModelName = Str::snake($this->modelName);
        $this->titleName = $this->strTitle($this->snakeModelName);
        $this->tableName = Str::plural($this->modelName);
        $this->camelTableName = Str::camel($this->tableName);
        $this->snakeTableName = Str::snake($this->tableName);
        $this->url = str_replace('_', '/', $this->snakeModelName);

        if($this->option('check')) {
            $this->info("modelName: " . $this->modelName);
            $this->info("kebabModelName: " . $this->kebabModelName);
            $this->info("camelModelName: " . $this->camelModelName);
            $this->info("snakeModelName: " . $this->snakeModelName);
            $this->info("titleName: " . $this->titleName);
            $this->info("tableName: " . $this->tableName);
            $this->info("camelTableName: " . $this->camelTableName);
            $this->info("snakeTableName: " . $this->snakeTableName);
            $this->info("url: " . $this->url);
        }

        $class = $this->modelNamespace . '\\' . $this->modelName;

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

            foreach($this->compileDetailFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                if(!$this->filesystem->exists($target)) {
                    $this->info("$target");
                }
            }

            foreach($this->compileFiles as $src=>$target) {
                $target = $this->replaceModelName($target);
                if(!$this->filesystem->exists($target)) {
                    $this->info("$target");
                }
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
            "require('./{$this->url}/list');",
            "require('./{$this->url}/create');",
            "require('./{$this->url}/edit');",
        ]);

        $this->updateRoute([
            "Route::resource('/{$this->url}', '{$this->modelName}Controller');",
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
                ['#ColumnName#', '#ColumnTitle#', '#modelName#', '#kebabModelName#', '#camelModelName#', '#snakeModelName#', '#titleName#', '#tableName#', '#camelTableName#', '#snakeTableName#', '#url#'],
                [$column, $columnTitle, $this->modelName, $this->kebabModelName, $this->camelModelName, $this->snakeModelName, $this->titleName, $this->tableName, $this->camelTableName, $this->snakeTableName, $this->url],
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
            ['#modelName#', '#kebabModelName#', '#camelModelName#', '#snakeModelName#', '#titleName#', '#tableName#', '#camelTableName#', '#snakeTableName#', '#url#'],
            [$this->modelName, $this->kebabModelName, $this->camelModelName, $this->snakeModelName, $this->titleName, $this->tableName, $this->camelTableName, $this->snakeTableName, $this->url],
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

        foreach($compileFiles as $filename=>$compiledFile) {

            if(Str::endsWith($filename, '.stub')) {
                $stubs = $this->filesystem->files(dirname($filename));

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

            } else {
                $src = base_path($filename);

                $target = $this->combinePath($targetDir, $compiledFile);

                if($this->filesystem->exists($src) && ($this->option('force') || !$this->filesystem->exists($target))) {

                    if (! $this->filesystem->isDirectory($directory = $this->filesystem->dirname($target))) {
                        $this->filesystem->makeDirectory($directory, 0755, true);
                    }
                    
                    $this->filesystem->copy($src, $target);
                    $this->info($filename);
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
