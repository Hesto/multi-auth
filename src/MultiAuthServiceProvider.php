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
        $this->registerInstallProviderCommand();
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

    /**
     * Register the adminlte:install command.
     */
    private function registerInstallProviderCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.provider', function ($app) {
            return $app['Hesto\MultiAuth\Commands\InstallProviderCommand'];
        });

        $this->commands('command.hesto.multi-auth.provider');
    }

    /**
     * Register the adminlte:install command.
     */
    private function registerInstallMiddlewareCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.middleware', function ($app) {
            return $app['Hesto\MultiAuth\Commands\InstallMiddlewareCommand'];
        });

        $this->commands('command.hesto.multi-auth.middleware');
    }

}
