<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Traits\CanReplaceKeywords;
use Hesto\Core\Commands\InstallAndReplaceCommand;
use Symfony\Component\Console\Input\InputOption;
use SplFileInfo;


class MultiAuthInstallCommand extends InstallAndReplaceCommand
{
    use CanReplaceKeywords;

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
            $this->info('Copied: ' . $path);
        }
    }

    /**
     * Install Web Routes.
     *
     * @return bool
     */
    public function installViews()
    {
        $name = $this->getNameInput();

        $path = '/resources/views/' . str_singular($name) . '/';
        $views = new SplFileInfo(__DIR__ . '/../stubs/views/');

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
        return '.php';
    }

    /**
     * Compile content.
     *
     * @param $content
     * @return mixed
     */
    protected function compile($content)
    {
        $content = $this->replaceNames($content);

        return $content;
    }
}
