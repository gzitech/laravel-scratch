<?php

namespace App\Providers;

use App\Contracts\Repositories\UserRepository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UserRepository $user)
    {
        $this->user = $user;

        Blade::directive('vueif', function() {
            $condition = config('app.frontend') === 'vue' ? 'true' : 'false';
            return "<?php if ($condition) { ?>";
        });

        Blade::directive('vuelse', function () {
            return "<?php } else { ?>";
        });

        Blade::directive('vuend', function () {
            return "<?php } ?>";
        });

        Blade::directive('reactif', function() {
            $condition = config('app.frontend') === 'react' ? 'true' : 'false';
            return "<?php if ($condition) { ?>";
        });

        Blade::directive('reactelse', function () {
            return "<?php } else { ?>";
        });

        Blade::directive('reactend', function () {
            return "<?php } ?>";
        });

        Blade::directive('noneif', function() {
            $condition = config('app.frontend') === 'none' ? 'true' : 'false';
            return "<?php if ($condition) { ?>";
        });

        Blade::directive('nonelse', function () {
            return "<?php } else { ?>";
        });

        Blade::directive('nonend', function () {
            return "<?php } ?>";
        });

        Blade::if('right', function ($right) {
            return $this->user->right($right) ;
        });
    }

    /**
     * Register the services.
     *
     * @return void
     */
    protected function registerServices()
    {
        $services = [
            'Contracts\Repositories\RbacRepository' => 'Repositories\RbacRepository',
            'Contracts\Repositories\RoleRepository' => 'Repositories\RoleRepository',
            'Contracts\Repositories\UserRepository' => 'Repositories\UserRepository',
            'Contracts\Repositories\CodeRepository' => 'Repositories\CodeRepository',
            'Contracts\Repositories\RightRepository' => 'Repositories\RightRepository',
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('App\\'.$key, 'App\\'.$value);
        }
    }
}
