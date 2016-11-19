<?php

namespace Hesto\MultiAuth\Commands\Traits;

trait ParsesServiceInput
{
    /**
     * Get and parse the service argument.
     *
     * @return mixed|string
     */
    protected function getParsedServiceInput()
    {
        return mb_strtolower(str_singular($this->getServiceInput()));
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