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
        $name = $this->getParsedNameInput();

        return [
            'routes' => [
                'path' => '/routes/' . $name .'.php',
                'stub' => __DIR__ . '/../stubs/routes/routes.stub',
            ],
            'middleware' => [
                'path' => '/app/Http/Middleware/RedirectIfNot' . ucfirst($name) .'.php',
                'stub' => __DIR__ . '/../stubs/Middleware/Middleware.stub',
            ],
            'guest_middleware' => [
                'path' => '/app/Http/Middleware/RedirectIf' . ucfirst($name) .'.php',
                'stub' => __DIR__ . '/../stubs/Middleware/GuestMiddleware.stub',
            ],
            'login_controller' => [
                'path' => '/app/Http/Controllers/' . ucfirst($name) . 'Auth/' . 'LoginController.php',
                'stub' => __DIR__ . '/../stubs/Controllers/LoginController.stub',
            ],
            'register_controller' => [
                'path' => '/app/Http/Controllers/' . ucfirst($name) . 'Auth/' . 'RegisterController.php',
                'stub' => __DIR__ . '/../stubs/Controllers/RegisterController.stub',
            ],
            'forgot_password_controller' => [
                'path' => '/app/Http/Controllers/' . ucfirst($name) . 'Auth/' . 'ForgotPasswordController.php',
                'stub' => __DIR__ . '/../stubs/Controllers/ForgotPasswordController.stub',
            ],
            'reset_password_controller' => [
                'path' => '/app/Http/Controllers/' . ucfirst($name) . 'Auth/' . 'ResetPasswordController.php',
                'stub' => __DIR__ . '/../stubs/Controllers/ResetPasswordController.stub',
            ],
            'reset_password_notification' => [
                'path' => '/app/Notifications/' . ucfirst($name) .'ResetPassword.php',
                'stub' => __DIR__ . '/../stubs/Notifications/ResetPassword.stub',
            ],
        ];
    }
}
