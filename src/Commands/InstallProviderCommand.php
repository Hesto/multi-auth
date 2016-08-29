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

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $path = $this->getPath();
        $fullPath = base_path() . $path;

        if($this->files->isDirectory($path)) {
            $this->installFiles($path, $this->files->allFiles($fullPath));

            return true;
        }

        $file = new \SplFileInfo($fullPath);

        if($this->putFile($fullPath, $file)) {
            $this->getInfoMessage($fullPath);
        }

        return true;
    }

    /**
     * Compile content.
     *
     * @param $content
     * @return mixed
     */
    protected function compile($content)
    {
        $string = $this->replaceNames($this->files->get($this->replaceWith()));

        $stub = $this->searchFor() . $string;

        $content = str_replace($this->searchFor(), $stub, $content);

        return $content;
    }

    protected function getInfoMessage($filePath)
    {
        $this->info('Content changed in: ' . $filePath);
    }
}
