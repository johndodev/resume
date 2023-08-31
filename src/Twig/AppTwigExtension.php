<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\ResumeItem;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppTwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('duration', $this->duration(...)),
            new TwigFilter('formattedDate', $this->formattedDate(...)),
        ];
    }

    /**
     * durée au format : "x ans y mois"
     */
    public function duration(ResumeItem $resumeItem): string
    {
        // La durée
        $duration = $resumeItem->getStartedAt()?->diff($resumeItem->getStoppedAt() ?: new \DateTime());

        // formatage
        $output = '';

        if ($duration?->y) {
            $output .= $duration->y > 1 ? $duration->y.' ans ' : $duration->y.' an ';
        }

        if ($duration?->m) {
            $output .= $duration->m.' mois';
        }

        return trim($output);
    }

    /**
     * Dates formattées au format "depuis x" ou "x - y"
     */
    public function formattedDate(ResumeItem $resumeItem): string
    {
        if (!$resumeItem->getStartedAt()) {
            return '';
        }

        if (!$resumeItem->getStoppedAt()) {
            // pas finis : "depuis x"
            $output = 'Depuis '.\IntlDateFormatter::formatObject($resumeItem->getStartedAt(), 'MMM y');
        } else {
            // finis : "x à y"
            $output =   \IntlDateFormatter::formatObject($resumeItem->getStartedAt(), 'MMM y').' - '
                . \IntlDateFormatter::formatObject($resumeItem->getStoppedAt(), 'MMM y');
        }

        return $output;
    }
}
