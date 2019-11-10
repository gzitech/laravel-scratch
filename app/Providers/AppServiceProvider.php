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

        Blade::if('vue', function () {
            return config('app.frontend') === 'vue';
        });

        Blade::if('react', function () {
            return config('app.frontend') === 'react';
        });

        Blade::if('none', function () {
            return config('app.frontend') === 'none';
        });

        Blade::if('right', function ($rights) {
            return $this->user->checkRights($rights);
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
            'Contracts\Repositories\RoleRepository' => 'Repositories\RoleRepository',
            'Contracts\Repositories\UserRepository' => 'Repositories\UserRepository',
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('App\\'.$key, 'App\\'.$value);
        }
    }
}
