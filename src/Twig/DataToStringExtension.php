<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use function get_class;
use function gettype;
use function is_object;
use function is_string;

class DataToStringExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('DateToString', [$this, 'fct_DateToString']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('DateToString', [$this, 'fct_DateToString']),
        ];
    }

    public function fct_DateToString($value)
    {
        if (is_string($value)) return $value;
        if (is_object($value) and get_class($value) == "DateTime")
            return $value->format('d/m/Y');
        return "pb : ". gettype($value);

    }
}
