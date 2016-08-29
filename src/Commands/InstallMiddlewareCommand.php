<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\ReplaceContentCommand;
use Symfony\Component\Console\Input\InputOption;


class InstallMiddlewareCommand extends ReplaceContentCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:kernel';

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
    public function getPath()
    {
        return '/app/Http/Kernel.php';
    }

    public function searchFor()
    {
        return 'protected $routeMiddleware = [';
    }

    public function replaceWith()
    {
        return __DIR__ . '/../stubs/Middleware/Kernel.stub';
    }
}
