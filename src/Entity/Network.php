<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="network")
 * @ORM\Entity()
 */
class Network
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="networks")
     */
    private Resume $resume;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $iconClass;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getResume(): Resume
    {
        return $this->resume;
    }

    public function getIconClass(): ?string
    {
        return $this->iconClass;
    }
}
