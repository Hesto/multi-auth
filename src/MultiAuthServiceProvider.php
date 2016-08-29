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
        $this->registerInstallSettingsCommand();
        $this->registerInstallAuthFilesCommand();
        //$this->registerInstallMiddlewareCommand();
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
    private function registerInstallSettingsCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.settings', function ($app) {
            return $app['Hesto\MultiAuth\Commands\InstallSettingsCommand'];
        });

        $this->commands('command.hesto.multi-auth.settings');
    }

    /**
     * Register the adminlte:install command.
     */
    private function registerInstallAuthFilesCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.files', function ($app) {
            return $app['Hesto\MultiAuth\Commands\InstallAuthFilesCommand'];
        });

        $this->commands('command.hesto.multi-auth.files');
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
