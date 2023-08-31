<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Realisation extends ResumeItem
{
    #[ORM\ManyToOne(inversedBy: 'realisations')]
    protected ?Resume $resume = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private int $ordering = 0;

    #[ORM\Column(type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $printDescription = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $visiblePrint = false;

    public function getPrintDescription(): ?string
    {
        return $this->printDescription;
    }

    public function isVisiblePrint(): bool
    {
        return $this->visiblePrint;
    }

    public function getOrdering(): int
    {
        return $this->ordering;
    }
}
