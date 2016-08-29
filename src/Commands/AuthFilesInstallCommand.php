<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallFilesCommand;
use Symfony\Component\Console\Input\InputOption;


class AuthFilesInstallCommand extends InstallFilesCommand
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
    protected $description = 'Install multi-auth files';

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
                'path' => '/routes/' . str_singular($name) .'.php',
                'stub' => __DIR__ . '/../stubs/routes/routes.stub',
            ],
//            'middleware' => [
//                'path' => '/app/Http/Middleware/RedirectIfNot' . ucfirst(str_singular($name)) .'.php',
//                'stub' => __DIR__ . '/../stubs/Middleware/Middleware.stub',
//            ],
            'login_controller' => [
                'path' => '/app/Http/Controllers/' . ucfirst(str_singular($name)) . 'Auth/' . 'LoginController.php',
                'stub' => __DIR__ . '/../stubs/Controllers/LoginController.stub',
            ],
            'register_controller' => [
                'path' => '/app/Http/Controllers/' . ucfirst(str_singular($name)) . 'Auth/' . 'RegisterController.php',
                'stub' => __DIR__ . '/../stubs/Controllers/RegisterController.stub',
            ],
        ];
    }
}
