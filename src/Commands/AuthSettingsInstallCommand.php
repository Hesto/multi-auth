<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\AppendContentCommand;
use Symfony\Component\Console\Input\InputOption;


class AuthSettingsInstallCommand extends AppendContentCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install settings in files';

    /**
     * Get the destination path.
     *
     * @return string
     */
    public function getSettings()
    {
        return [
            'guard' => [
                'path' => '/config/auth.php',
                'search' => "'guards' => [",
                'stub' => __DIR__ . '/../stubs/config/guards.stub',
                'prefix' => false,
            ],
            'provider' => [
                'path' => '/config/auth.php',
                'search' => "'providers' => [",
                'stub' => __DIR__ . '/../stubs/config/providers.stub',
                'prefix' => false,
            ],
            'passwords' => [
                'path' => '/config/auth.php',
                'search' => "'passwords' => [",
                'stub' => __DIR__ . '/../stubs/config/passwords.stub',
                'prefix' => false,
            ],
            'kernel' => [
                'path' => '/app/Http/Kernel.php',
                'search' => 'protected $routeMiddleware = [',
                'stub' => __DIR__ . '/../stubs/Middleware/Kernel.stub',
                'prefix' => false,
            ],
            'map_register' => [
                'path' => '/app/Providers/RouteServiceProvider.php',
                'search' => '$this->mapWebRoutes();',
                'stub' => __DIR__ . '/../stubs/routes/map-register.stub',
                'prefix' => false,
            ],
            'map_method' => [
                'path' => '/app/Providers/RouteServiceProvider.php',
                'search' => "    /**\n" . '     * Define the "web" routes for the application.',
                'stub' => __DIR__ . '/../stubs/routes/map-method.stub',
                'prefix' => true,
            ],
        ];
    }
}
