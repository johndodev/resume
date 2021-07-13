<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="experience")
 * @ORM\Entity()
 */
class Experience extends ResumeItem
{
    /**
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="experiences")
     */
    protected Resume $resume;
}
