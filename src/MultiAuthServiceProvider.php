<?php

namespace Hesto\MultiAuth;

use Illuminate\Support\ServiceProvider;

class MultiAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInstallCommand();
    }

    /**
     * Register the adminlte:install command.
     */
    private function registerInstallCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.install', function ($app) {
            return $app['Hesto\MultiAuth\Commands\MultiAuthInstallCommand'];
        });

        $this->commands('command.hesto.multi-auth.install');
    }

}
