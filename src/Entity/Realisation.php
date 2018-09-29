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
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="degrees")
     */
    protected $resume;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ordering;
}
