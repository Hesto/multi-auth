<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallAndReplaceCommand;
use Symfony\Component\Console\Input\InputOption;
use SplFileInfo;


class AuthViewsInstallCommand extends InstallAndReplaceCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install multi-auth views';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $this->installViews();
    }

    /**
     * Install Web Routes.
     *
     * @return bool
     */
    public function installViews()
    {
        $name = $this->getParsedNameInput();

        $path = '/resources/views/' . $name . '/';
        $views = __DIR__ . '/../stubs/views/';

        if($this->installFiles($path, $this->files->allFiles($views))) {
            $this->info('Copied: ' . $path);
        }
    }

    /**
     * Get file extension.
     *
     * @param $file
     * @return bool
     */
    protected function getExtension($file)
    {
        return 'php';
    }
}
