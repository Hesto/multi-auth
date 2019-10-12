<?php

namespace Hesto\MultiAuth\Commands\Traits;

use Illuminate\Support\Str;

trait OverridesCanReplaceKeywords
{
    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getParsedNameInput()
    {
        return mb_strtolower(Str::singular($this->getNameInput()));
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Replace names with pattern.
     *
     * @param $template
     * @return $this
     */
    public function replaceNames($template)
    {
        $name = $this->getParsedNameInput();
        $service = $this->getParsedServiceInput();

        $name = Str::plural($name);

        $plural = [
            '{{pluralCamel}}',
            '{{pluralSlug}}',
            '{{pluralSnake}}',
            '{{pluralClass}}',
        ];

        $singular = [
            '{{singularCamel}}',
            '{{singularSlug}}',
            '{{singularSnake}}',
            '{{singularClass}}',

            '{{singularServiceCamel}}',
            '{{singularServiceSlug}}',
            '{{singularServiceSnake}}',
            '{{singularServiceClass}}',
        ];

        $replacePlural = [
            Str::camel($name),
            Str::slug($name),
            Str::snake($name),
            ucfirst(Str::camel($name)),
        ];

        $replaceSingular = [
            Str::singular(Str::camel($name)),
            Str::singular(Str::slug($name)),
            Str::singular(Str::snake($name)),
            Str::singular(ucfirst(Str::camel($name))),

            Str::camel($service),
            Str::slug($service),
            Str::snake($service),
            ucfirst(Str::camel($service)),
        ];



        $template = str_replace($plural, $replacePlural, $template);
        $template = str_replace($singular, $replaceSingular, $template);
        $template = str_replace('{{Class}}', ucfirst(Str::camel($name)), $template);

        return $template;
    }
}