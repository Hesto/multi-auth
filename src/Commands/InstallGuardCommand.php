<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\ReplaceContentCommand;
use Symfony\Component\Console\Input\InputOption;


class InstallGuardCommand extends ReplaceContentCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:guard';

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
        return "'guards' => [";
    }

    public function replaceWith()
    {
        return __DIR__ . '/../stubs/config/guards.stub';
    }
}
