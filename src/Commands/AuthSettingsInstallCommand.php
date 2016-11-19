<?php

namespace Hesto\MultiAuth\Commands;

use Hesto\Core\Commands\AppendContentCommand;
use Hesto\MultiAuth\Commands\Traits\OverridesCanReplaceKeywords;
use Hesto\MultiAuth\Commands\Traits\OverridesGetArguments;
use Hesto\MultiAuth\Commands\Traits\ParsesServiceInput;
use Symfony\Component\Console\Input\InputOption;


class AuthSettingsInstallCommand extends AppendContentCommand
{
    use OverridesCanReplaceKeywords, OverridesGetArguments, ParsesServiceInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-auth:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install settings in files';

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        $parentOptions = parent::getOptions();
        return array_merge($parentOptions, [
            ['lucid', false, InputOption::VALUE_NONE, 'Lucid architecture'],
            ['domain', false, InputOption::VALUE_NONE, 'Install in a subdomain'],
        ]);
    }

    /**
     * Get the necessary settings, override if necessary.
     *
     * @return array|string
     */
    public function getSettings()
    {
        $lucid = $this->option('lucid');
        $settings = $this->getGeneralSettings();

        // If the --domain was passed, but not --lucid
        if ($this->option('domain') && ! $lucid) {
            return array_replace_recursive($settings, $this->getDomainMapMethod());
        }

        // If --lucid was passed
        if ($lucid) {
            $lucidSettings = array_merge($settings, $this->getLucidSettings());
            unset($lucidSettings['map_method']);
            return $lucidSettings;
        }

        // Return the default general settings
        return $settings;
    }

    /**
     * Get the general settings.
     *
     * @return string
     */
    public function getGeneralSettings()
    {
        return [
            'guard' => [
                'path' => '/config/auth.php',
                'search' => "'guards' => [",
                'stub' => __DIR__ . '/../stubs/config/guards.stub',
                'prefix' => false,
            ],
            'provider' => [
                'path' => '/config/auth.php',
                'search' => "'providers' => [",
                'stub' => __DIR__ . '/../stubs/config/providers.stub',
                'prefix' => false,
            ],
            'passwords' => [
                'path' => '/config/auth.php',
                'search' => "'passwords' => [",
                'stub' => __DIR__ . '/../stubs/config/passwords.stub',
                'prefix' => false,
            ],
            'kernel' => [
                'path' => '/app/Http/Kernel.php',
                'search' => 'protected $routeMiddleware = [',
                'stub' => __DIR__ . '/../stubs/Middleware/Kernel.stub',
                'prefix' => false,
            ],
            'map_register' => [
                'path' => '/app/Providers/RouteServiceProvider.php',
                'search' => '$this->mapWebRoutes();',
                'stub' => __DIR__ . '/../stubs/routes/map-register.stub',
                'prefix' => false,
            ],
            'map_method' => [
                'path' => '/app/Providers/RouteServiceProvider.php',
                'search' => "    /**\n" . '     * Define the "web" routes for the application.',
                'stub' => __DIR__ . '/../stubs/routes/map-method.stub',
                'prefix' => true,
            ],
        ];
    }

    /**
     * Get the override map_method for domain option.
     *
     * @return array
     */
    public function getDomainMapMethod()
    {
        return [
            'map_method' => [
                'stub' => __DIR__ . '/../stubs/domain-routes/map-method.stub',
            ]
        ];
    }

    /**
     * Get the specific settings for the Lucid options.
     *
     * @return array
     */
    public function getLucidSettings()
    {
        $service = $this->getParsedServiceInput();
        $general = [
            'provider' => [
                'path' => '/config/auth.php',
                'search' => "'providers' => [",
                'stub' => __DIR__ . '/../stubs/Lucid/config/providers.stub',
                'prefix' => false,
            ],
            'kernel' => [
                'path' => '/app/Http/Kernel.php',
                'search' => 'protected $routeMiddleware = [',
                'stub' => __DIR__ . '/../stubs/Lucid/Middleware/Kernel.stub',
                'prefix' => false,
            ],
            'map_register' => [
                'path' => '/src/Services/' . studly_case($service) . '/Providers/RouteServiceProvider.php',
                'search' => '$this->loadRoutesFile($router, $namespace, $routesPath);',
                'stub' => __DIR__ . '/../stubs/Lucid/routes/map-register.stub',
                'prefix' => false,
            ],
        ];

        return $general;
    }

}
