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
        $this->registerInstallGuardCommand();
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

    /**
     * Register the adminlte:install command.
     */
    private function registerInstallGuardCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.guard', function ($app) {
            return $app['Hesto\MultiAuth\Commands\InstallGuardCommand'];
        });

        $this->commands('command.hesto.multi-auth.guard');
    }

}
