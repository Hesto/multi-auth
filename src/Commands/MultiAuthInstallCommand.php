<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallAndReplaceCommand;
use Illuminate\Support\Facades\Artisan;
use SplFileInfo;
use Symfony\Component\Console\Input\InputOption;


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
        if($this->option('force')) {
            $name = $this->getParsedNameInput();


            Artisan::call('multi-auth:settings', [
                'name' => $name,
                '--force' => true
            ]);

            Artisan::call('multi-auth:files', [
                'name' => $name,
                '--force' => true
            ]);

            if(!$this->option('model')) {
                Artisan::call('multi-auth:model', [
                    'name' => $name,
                    '--force' => true
                ]);

                $this->installMigration();
            }

            if(!$this->option('views')) {
                Artisan::call('multi-auth:views', [
                    'name' => $name,
                    '--force' => true
                ]);
            }

            if(!$this->option('routes')) {
                $this->installWebRoutes();
            }

            $this->info('Multi Auth with ' . ucfirst($name) . ' guard successfully installed.');

            return true;
        }

        $this->info('Use `-f` flag first.');

        return true;
    }

    /**
     * Install Web Routes.
     *
     * @return bool
     */
    public function installWebRoutes()
    {
        $path = base_path() . '/routes/web.php';
        $stub = __DIR__ . '/../stubs/routes/web.stub';

        if( ! $this->contentExists($path, $stub)) {
            $file = new SplFileInfo($stub);
            $this->appendFile($path, $file);

            return true;
        }

        return false;

    }

    /**
     * Install Migration.
     *
     * @return bool
     */
    public function installMigration()
    {
        $name = $this->getParsedNameInput();

        $migrationDir = base_path() . '/database/migrations/';
        $migrationName = 'create_' . str_plural(snake_case($name)) .'_table.php';
        $migrationStub = new SplFileInfo(__DIR__ . '/../stubs/Model/migration.stub');

        $files = $this->files->allFiles($migrationDir);

        foreach ($files as $file) {
            if(str_contains($file->getFilename(), $migrationName)) {
                $this->putFile($file->getPathname(), $migrationStub);

                return true;
            }
        }

        $path = $migrationDir . date('Y_m_d_His') . '_' . $migrationName;
        $this->putFile($path, $migrationStub);

        return true;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
            ['model', null, InputOption::VALUE_NONE, 'Exclude model and migration'],
            ['views', null, InputOption::VALUE_NONE, 'Exclude views'],
            ['routes', null, InputOption::VALUE_NONE, 'Exclude routes'],
        ];
    }
}
