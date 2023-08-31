<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Degree extends ResumeItem
{
    #[ORM\ManyToOne(inversedBy: 'degrees')]
    protected Resume $resume;
}
