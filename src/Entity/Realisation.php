<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="realisation")
 * @ORM\Entity(readOnly=true)
 */
class Realisation extends ResumeItem
{
    /**
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="realisations")
     */
    protected Resume $resume;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $ordering;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $printDescription;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $visiblePrint = false;

    public function getPrintDescription(): ?string
    {
        return $this->printDescription;
    }

    public function isVisiblePrint(): bool
    {
        return $this->visiblePrint;
    }
}
