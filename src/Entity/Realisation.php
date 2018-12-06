<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="realisation")
 * @ORM\Entity()
 */
class Realisation extends ResumeItem
{
    /**
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="realisations")
     */
    protected $resume;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ordering;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $printDescription;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visiblePrint;

    /**
     * @return mixed
     */
    public function getVisiblePrint()
    {
        return $this->visiblePrint;
    }

    /**
     * @return mixed
     */
    public function getPrintDescription()
    {
        return $this->printDescription;
    }
}
