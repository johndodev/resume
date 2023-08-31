<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Network
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'networks')]
    private ?Resume $resume = null;

    #[ORM\Column]
    private ?string $iconClass = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function getIconClass(): ?string
    {
        return $this->iconClass;
    }
}
