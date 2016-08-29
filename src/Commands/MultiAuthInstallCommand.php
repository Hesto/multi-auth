<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallAndReplaceCommand;
use Symfony\Component\Console\Input\InputOption;
use SplFileInfo;


class MultiAuthInstallCommand extends InstallAndReplaceCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Multi Auth into Laravel 5.3 project';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $this->installWebRoutes();
    }

    /**
     * Install Web Routes.
     *
     * @return bool
     */
    public function installWebRoutes()
    {
        $path = base_path() . '/routes/web.php';
        $file = new SplFileInfo(__DIR__ . '/../stubs/routes/web.stub');

        if($this->appendFile($path, $file)) {
            $this->info('Routes add in: ' . $path);
        }
    }
}
