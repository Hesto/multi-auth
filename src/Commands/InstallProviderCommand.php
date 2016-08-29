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
    public function getPath()
    {
        return '/config/auth.php';
    }

    public function searchFor()
    {
        return "'providers' => [";
    }

    public function replaceWith()
    {
        return __DIR__ . '/../stubs/config/providers.stub';
    }
}
