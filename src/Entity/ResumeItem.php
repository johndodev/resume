<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Décrit un élément d'un CV comprenant : titre, description, date de début et de fin, url et label
 * Ex : une expérience professionnelle ou un diplome
 */
#[ORM\MappedSuperclass]
abstract class ResumeItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64, nullable: true)]
    protected ?string $title;

    #[ORM\Column(nullable: true)]
    protected ?string $url;

    #[ORM\Column(length: 64, nullable: true)]
    protected ?string $urlLabel;

    #[ORM\Column(type: Types::TEXT, length: 65535, nullable: true)]
    protected ?string $description;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    protected ?\DateTime $startedAt;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
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
