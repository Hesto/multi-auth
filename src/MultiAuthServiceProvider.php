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
        $this->registerAuthSettingsInstallCommand();
        $this->registerAuthFilesInstallCommand();
        $this->registerAuthModelInstallCommand();
        $this->registerAuthViewsInstallCommand();
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
    private function registerAuthSettingsInstallCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.settings', function ($app) {
            return $app['Hesto\MultiAuth\Commands\AuthSettingsInstallCommand'];
        });

        $this->commands('command.hesto.multi-auth.settings');
    }

    /**
     * Register the adminlte:install command.
     */
    private function registerAuthFilesInstallCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.files', function ($app) {
            return $app['Hesto\MultiAuth\Commands\AuthFilesInstallCommand'];
        });

        $this->commands('command.hesto.multi-auth.files');
    }

    /**
     * Register the adminlte:install command.
     */
    private function registerAuthModelInstallCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.model', function ($app) {
            return $app['Hesto\MultiAuth\Commands\AuthModelInstallCommand'];
        });

        $this->commands('command.hesto.multi-auth.model');
    }

    /**
     * Register the adminlte:install command.
     */
    private function registerAuthViewsInstallCommand()
    {
        $this->app->singleton('command.hesto.multi-auth.views', function ($app) {
            return $app['Hesto\MultiAuth\Commands\AuthViewsInstallCommand'];
        });

        $this->commands('command.hesto.multi-auth.views');
    }

}
