<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="degree")
 * @ORM\Entity()
 */
class Degree extends ResumeItem
{
    /**
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="degrees")
     */
    protected Resume $resume;
}
