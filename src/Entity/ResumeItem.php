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
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected ?string $title;

    /**
     * @ORM\Column(type="string", nullable=true)
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
     * @ORM\Column(name="stopped_at", type="date", nullable=true)
     */
    protected ?\DateTime $stoppedAt;

    public function getId(): int
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

    public function getStoppedAt(): ?\DateTime
    {
        return $this->stoppedAt;
    }
}
