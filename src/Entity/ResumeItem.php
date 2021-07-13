<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Décrit un élément d'un CV comprenant : titre, description, date de début et de fin, url et label
 * Ex : une expérience professionnelle ou un diplome
 *
 * @ORM\MappedSuperclass
 */
abstract class ResumeItem
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $url;

    /**
     * @ORM\Column(name="url_label", type="string", length=64, nullable=true)
     */
    protected ?string $urlLabel;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected ?string $description;

    /**
     * @ORM\Column(name="started_at", type="date", nullable=true)
     */
    protected ?\DateTime $startedAt;

    /**
     * @ORM\Column(name="stoped_at", type="date", nullable=true)
     */
    protected ?\DateTime $stopedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getUrlLabel(): ?string
    {
        return $this->urlLabel;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStartedAt(): ?\DateTime
    {
        return $this->startedAt;
    }

    public function getStopedAt(): ?\DateTime
    {
        return $this->stopedAt;
    }

    /**
     * Dates formattées au format "depuis x" ou "x - y"
     * TODO dans twig
     */
    public function getFormattedDate(): string
    {
        if(!$this->getStopedAt()) {
            // pas finis : "depuis x"
            $output = 'Depuis '.strftime('%b %Y', $this->getStartedAt()->getTimestamp());
        } else {
            // finis : "x à y"
            $output =   strftime('%b %Y', $this->getStartedAt()->getTimestamp()).' - '
                         . strftime('%b %Y', $this->getStopedAt()->getTimestamp());
        }

        return $output;
    }

    /**
     * durée au format : "x ans, y mois"
     * TODO dans twig
     */
    public function getFormattedDuration(): string
    {
        // La durée
        $duration = $this->getStartedAt()->diff($this->getStopedAt() ?: new \DateTime(), true);

        // formatage
        $output = '';

        foreach (['y' => 'an(s)', 'm' => 'mois'] as $intervalField => $translation) {
            if ($duration->$intervalField) {
                $output .= $duration->$intervalField.' '.$translation.' ';
            }
        }

        return $output;
    }
}
