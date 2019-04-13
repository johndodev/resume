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
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $url;

    /**
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="networks")
     * @ORM\JoinColumn(name="resume_id", referencedColumnName="id")
     * @var Resume
     */
    protected $resume;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $iconClass;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return Resume
     */
    public function getResume(): Resume
    {
        return $this->resume;
    }

    /**
     * @return string
     */
    public function getIconClass(): string
    {
        return $this->iconClass;
    }
}
