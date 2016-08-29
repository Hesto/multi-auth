<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallFilesCommand;
use Symfony\Component\Console\Input\InputOption;


class AuthModelInstallCommand extends InstallFilesCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:model';

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
            'model' => [
                'path' => '/app/' . ucfirst(str_singular($name)) .'.php',
                'stub' => __DIR__ . '/../stubs/Model/Model.stub',
            ],
            'migration' => [
                'path' => '/database/migrations/create_' . str_plural(snake_case($name)) .'_table.php',
                'stub' => __DIR__ . '/../stubs/Model/migration.stub',
            ],
        ];
    }
}
