<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('days_diff', [$this, 'daysInterval']),
            new TwigFunction('years_diff', [$this, 'yearsInterval'])
        ];
    }

    public function daysInterval($date)
    {
    	$currentDate = new \DateTime();
        $daysInterval = $currentDate->diff($date);
		$formattedDate = $daysInterval->format('%a');

        return $formattedDate;
    }

    public function yearsInterval($date)
    {
    	$currentDate = new \DateTime();
        $yearsInterval = $currentDate->diff($date);
		$formattedDate = $yearsInterval->format('%y');

        return $formattedDate;
    }
}