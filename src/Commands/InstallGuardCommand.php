<?php

namespace Hesto\Core\Commands;

use Illuminate\Filesystem\Filesystem;
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
        return 'config/auth.php';
    }

    public function searchFor()
    {
        return "'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],";
    }

    public function replaceWith()
    {
        return __DIR__ . '/../stubs/config/guard.stub';
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
        $content = str_replace($this->searchFor(), $this->replaceWith(), $content);

        return $content;
    }

    protected function getInfoMessage($filePath)
    {
        return $this->info('Content changed in: ' . $filePath);
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
