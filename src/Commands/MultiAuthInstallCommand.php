<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallCommand;
use Symfony\Component\Console\Input\InputOption;
use SplFileInfo;


class MultiAuthInstallCommand extends InstallCommand
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
    protected $description = 'Install Multi Auth files into Laravel 5 project';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $this->installControllers();
        $this->installGuard();
        $this->installMiddleware();

    }

    /**
     * Install Admin Auth Controllers.
     *
     */
    public function installControllers()
    {
        $files = $this->files->allFiles(__DIR__ . '/../../resources/Controllers/');
        $this->installFiles('/app/Http/Controllers/', $files);
    }

    /**
     * Install guard and passwords.
     *
     */
    public function installGuard()
    {
//        $gulpfile = new SplFileInfo(__DIR__ . '/../../resources/gulpfile.js');
//        $path = base_path() . '/gulpfile.js';
//
//        $this->putFile($path, $gulpfile);
    }

    /**
     * Install Middleware.
     *
     * @return bool
     */
    public function installMiddleware()
    {
        $middleware = new SplFileInfo(__DIR__ . '/../../resources/Middleware/RedirectIfNotAdmin.php');
        $path = base_path() . '/app/Http/Middleware/RedirectIfNotAdmin.php';

        if($this->putFile($path, $middleware)) {
            $this->info('Copied: ' . $path);
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
        ];
    }
}
