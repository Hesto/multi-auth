<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallAndReplaceCommand;
use Illuminate\Support\Facades\Artisan;
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
        $name = mb_strtolower($this->getNameInput());

        Artisan::call('multi-auth:settings', [
            'name' => $name,
            '--force' => true
        ]);

        Artisan::call('multi-auth:files', [
            'name' => $name,
            '--force' => true
        ]);

        Artisan::call('multi-auth:model', [
            'name' => $name,
            '--force' => true
        ]);

        Artisan::call('multi-auth:views', [
            'name' => $name,
            '--force' => true
        ]);

        $this->installWebRoutes();

        $this->info('Multi Auth with ' . ucfirst($name) . ' guard successfully installed.');
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

        $this->appendFile($path, $file);
    }
}
