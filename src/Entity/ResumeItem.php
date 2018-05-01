<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Décrit un élément d'un CV comprenant : titre, description, date de début et de fin, url (et label)
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
    protected $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(name="url_label", type="string", length=64, nullable=true)
     */
    protected $urlLabel;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="started_at", type="date", nullable=true)
     */
    protected $startedAt;

    /**
     * @ORM\Column(name="stoped_at", type="date", nullable=true)
     */
    protected $stopedAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getUrlLabel()
    {
        return $this->urlLabel;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * @return mixed
     */
    public function getStopedAt()
    {
        return $this->stopedAt;
    }

    /**
     * @return string Dates formattées au format "depuis x" ou "x - y"
     * TODO dans twig
     */
    public function getFormattedDate()
    {
        if(!$this->getStopedAt()) {
            // pas finis : "depuis x"
            $output = 'Depuis '.strftime('%b %Y', $this->getStartedAt()->getTimestamp());
        } else {
            // finis : "x à y"
            $output =   strftime('%b %Y', $this->getStartedAt()->getTimestamp()).' - '.
                        strftime('%b %Y', $this->getStopedAt()->getTimestamp());
        }

        return $output;
    }

    /**
     * @return string durée au format : "x ans, y mois"
     * TODO dans twig
     */
    public function getFormattedDuration()
    {
        // La durée
        $duration = $this->getStartedAt()->diff($this->getStopedAt() ?: new \DateTime(), true);

        // formatage
        $output = '';

        foreach (['y' => 'an(s)', 'm' => 'mois'] as $intervalField => $translation) {
            if($duration->$intervalField) {
                $output.= $duration->$intervalField.' '.$translation.' ';
            }
        }

        return $output;
    }
}
