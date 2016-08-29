<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\ReplaceContentCommand;
use Symfony\Component\Console\Input\InputOption;


class InstallProviderCommand extends ReplaceContentCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * Get the destination path.
     *
     * @return string
     */
    public function getFiles()
    {
        return [
            'guard' => [
                'path' => '/config/auth.php',
                'search' => "'guards' => [",
                'replace' => __DIR__ . '/../stubs/config/guards.stub',
            ],
            'provider' => [
                'path' => '/config/auth.php',
                'search' => "'providers' => [",
                'replace' => __DIR__ . '/../stubs/config/providers.stub',
            ],
            'kernel' => [
                'path' => '/app/Http/Kernel.php',
                'search' => 'protected $routeMiddleware = [',
                'replace' => __DIR__ . '/../stubs/Middleware/Kernel.stub',
            ],
        ];
    }
}
