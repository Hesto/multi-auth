<?php

namespace Hesto\MultiAuth\Commands\Traits;

use Symfony\Component\Console\Input\InputArgument;

trait OverridesGetArguments
{
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        // Get the parent arguments
        $parentArguments = parent::getArguments();

        // Merge them with the lucid specific arguments
        return array_merge($parentArguments, [
            ['service', InputArgument::OPTIONAL, 'The name of the service'],
        ]);
    }
}
