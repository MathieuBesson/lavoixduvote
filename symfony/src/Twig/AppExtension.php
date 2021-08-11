<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('clean_class', [$this, 'cleanClass']),
        ];
    }

    /**
     * Prepare a string to be used as a css class :
     * - replace space
     * - replace accent
     * - all in lowercase
     *
     * @param $stringToClean
     * @return string
     */
    public function cleanClass($stringToClean)
    {
        // remove all spaces
        $string = str_replace(' ', '-', $stringToClean);

        // replace accents
        $string = htmlentities($string, ENT_NOQUOTES, 'utf-8');
        $string = preg_replace('#&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', $string);
        $string = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string);
        $string = preg_replace('#&[^;]+;#', '', $string);

        // all lowercase
        return strtolower($string);
    }
}