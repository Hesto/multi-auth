<?php

namespace Hesto\MultiAuth\Commands\Traits;

use Illuminate\Support\Str;

trait ParsesServiceInput
{
    /**
     * Get and parse the service argument.
     *
     * @return mixed|string
     */
    protected function getParsedServiceInput()
    {
        return mb_strtolower(Str::singular($this->getServiceInput()));
    }

    /**
     * Get the name of the lucid service passed as argument.
     *
     * @return string
     */
    protected function getServiceInput()
    {
        return trim($this->argument('service'));
    }
}