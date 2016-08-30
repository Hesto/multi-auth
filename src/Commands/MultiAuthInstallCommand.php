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

    /**
     * Install Migration.
     *
     * @return bool
     */
    public function installMigration()
    {
        $name = $this->getNameInput();

        $migrationDir = base_path() . '/database/migrations/';
        $migrationName = 'create_' . str_plural(snake_case($name)) .'_table.php';
        $migrationStub = new SplFileInfo(__DIR__ . '/../stubs/Model/migration.stub');

        $files = $this->files->allFiles($migrationDir);

        foreach ($files as $file) {
            if(str_contains($file->getFilename(), $migrationName)) {
                $this->putFile($file->getPath(), $migrationStub);

                return true;
            }
        }

        $path = $migrationDir . date('Y_m_d_His') . '_' . $migrationName;
        $this->putFile($path, $migrationStub);

        return true;
    }
}
