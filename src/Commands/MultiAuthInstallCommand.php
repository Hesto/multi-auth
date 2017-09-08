<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\InstallAndReplaceCommand;
use Hesto\MultiAuth\Commands\Traits\OverridesCanReplaceKeywords;
use Hesto\MultiAuth\Commands\Traits\OverridesGetArguments;
use Hesto\MultiAuth\Commands\Traits\ParsesServiceInput;
use Illuminate\Support\Facades\Artisan;
use SplFileInfo;
use Symfony\Component\Console\Input\InputOption;


class MultiAuthInstallCommand extends InstallAndReplaceCommand
{
    use OverridesCanReplaceKeywords, OverridesGetArguments, ParsesServiceInput;

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
    public function handle()
    {
        if ($this->option('lucid') && ! $this->getParsedServiceInput()) {
            $this->error('You must pass a Service name with the `--lucid` option.');

            return true;
        }

        if ($this->option('force')) {
            $name = $this->getParsedNameInput();
            $domain = $this->option('domain');
            $lucid = $this->option('lucid');
            $service = $this->getParsedServiceInput() ?: null;


            Artisan::call('multi-auth:settings', [
                'name' => $name,
                'service' => $service,
                '--domain' => $domain,
                '--lucid' => $lucid,
                '--force' => true
            ]);

            Artisan::call('multi-auth:files', [
                'name' => $name,
                'service' => $service,
                '--domain' => $domain,
                '--lucid' => $lucid,
                '--force' => true
            ]);

            if(!$this->option('model')) {
                Artisan::call('multi-auth:model', [
                    'name' => $name,
                    '--lucid' => $lucid,
                    '--force' => true
                ]);

                $this->installMigration();
                $this->installPasswordResetMigration();
            }

            if(!$this->option('views')) {
                Artisan::call('multi-auth:views', [
                    'name' => $name,
                    'service' => $service,
                    '--lucid' => $lucid,
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
        $lucid = $this->option('lucid');
        $domain = $this->option('domain');
        $service = $this->getParsedServiceInput();

        if ($lucid) {
            $stub = ! $domain
                ? __DIR__ . '/../stubs/Lucid/routes/web.stub'
                : __DIR__ . '/../stubs/Lucid/domain-routes/web.stub';

            $lucidPath =  base_path() . '/src/Services/' . studly_case($service) . '/Http/routes.php';
            $lucidStub = ! $domain
                ? __DIR__ . '/../stubs/Lucid/routes/map-method.stub'
                : __DIR__ . '/../stubs/Lucid/domain-routes/map-method.stub';

            if ( ! $this->contentExists($lucidPath, $lucidStub)) {
                $lucidFile = new SplFileInfo($lucidStub);
                $this->appendFile($lucidPath, $lucidFile);
            }

            if( ! $this->contentExists($lucidPath, $stub)) {
                $file = new SplFileInfo($stub);
                $this->appendFile($lucidPath, $file);

                return true;
            }

            return false;
        }

        $path = base_path() . '/routes/web.php';
        $stub = __DIR__ . '/../stubs/routes/web.stub';
        if ($domain) {
            $stub = __DIR__ . '/../stubs/domain-routes/web.stub';
        }

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
     * Install PasswordResetMigration.
     *
     * @return bool
     */
    public function installPasswordResetMigration()
    {
        $name = $this->getParsedNameInput();

        $migrationDir = base_path() . '/database/migrations/';
        $migrationName = 'create_' . str_singular(snake_case($name)) .'_password_resets_table.php';
        $migrationStub = new SplFileInfo(__DIR__ . '/../stubs/Model/PasswordResetMigration.stub');

        $files = $this->files->allFiles($migrationDir);

        foreach ($files as $file) {
            if(str_contains($file->getFilename(), $migrationName)) {
                $this->putFile($file->getPathname(), $migrationStub);

                return true;
            }
        }

        $path = $migrationDir . date('Y_m_d_His', strtotime('+1 second')) . '_' . $migrationName;
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
            ['domain', false, InputOption::VALUE_NONE, 'Install in a subdomain'],
            ['lucid', false, InputOption::VALUE_NONE, 'Lucid architecture'],
            ['model', null, InputOption::VALUE_NONE, 'Exclude model and migration'],
            ['views', null, InputOption::VALUE_NONE, 'Exclude views'],
            ['routes', null, InputOption::VALUE_NONE, 'Exclude routes'],
        ];
    }
}
