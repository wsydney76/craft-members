<?php

namespace wsydney76\members\twigextensions;

use Craft;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Twig extension
 */
class TwigExtension extends AbstractExtension
{


    public function getFunctions()
    {
        return [
            new TwigFunction('members', [$this, 'membersFunction'])
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('members', [$this, 'membersFunction'])
        ];
    }

    public function membersFunction(string $template) {
        return [
            $template,
            "_members/$template",
            "@members/$template"
        ];
    }

}
