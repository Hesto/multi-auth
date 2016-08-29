<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallFilesCommand;
use Symfony\Component\Console\Input\InputOption;


class InstallAuthFilesCommand extends InstallFilesCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install settings in files';

    /**
     * Get the destination path.
     *
     * @return string
     */
    public function getFiles()
    {
        $name = $this->getNameInput();

        return [
            'routes' => [
                'path' => '/routes/' . $name .'.php',
                'stub' => __DIR__ . '/../stubs/routes/routes.stub',
            ],
            'middleware' => [
                'path' => '/app/Http/Middleware/RedirectIfNot' . ucfirst($name) .'.php',
                'stub' => __DIR__ . '/../stubs/routes/routes.stub',
            ],
            'login_controller' => [
                'path' => '/app/Http/Controllers/' . ucfirst($name) . 'Auth/' . 'LoginController.php',
                'stub' => __DIR__ . '/../stubs/Controllers/LoginController.stub',
            ],
        ];
    }
}
