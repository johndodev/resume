<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResumeRepository", readOnly=true)
 * @ORM\Table(name="resume")
 */
class Resume
{
    public const STATUS_TYPE_AVAILABLE = 'available';
    public const STATUS_TYPE_BUSY = 'busy';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected ?\DateTime $updatedAt;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $name;

    /**
     * @ORM\Column(type="date")
     */
    protected \DateTime $birthdate;

    /**
     * @ORM\Column(name="job_title", type="string", length=64)
     */
    protected string $jobTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $status;

    /**
     * @ORM\Column(name="status_type", type="string")
     * TODO enum
     */
    protected string $statusType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $photo;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $city;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $email;

    /**
     * @ORM\Column(type="text")
     */
    protected string $about;

    /**
     * @ORM\OneToMany(targetEntity="Experience", mappedBy="resume")
     * @ORM\OrderBy({"startedAt" = "DESC"})
     * @var Collection<int, Experience>
     */
    protected Collection $experiences;

    /**
     * @ORM\OneToMany(targetEntity="Degree", mappedBy="resume")
     * @ORM\OrderBy({"startedAt" = "DESC"})
     * @var Collection<int, Degree>
     */
    protected Collection $degrees;

    /**
     * @ORM\OneToMany(targetEntity="Network", mappedBy="resume")
     * @ORM\OrderBy({"id" = "ASC"})
     * @var Collection<int, Network>
     */
    protected Collection $networks;

    /**
     * @ORM\OneToMany(targetEntity="Realisation", mappedBy="resume")
     * @ORM\OrderBy({"ordering" = "ASC"})
     * @var Collection<int, Realisation>
     */
    protected Collection $realisations;

    private ?\DateInterval $age = null;

    /**
     * Durée totale de l'experience
     */
    private ?\DateInterval $experienceDuration = null;

    public function __construct()
    {
        $this->experiences = new ArrayCollection();
        $this->degrees = new ArrayCollection();
        $this->networks = new ArrayCollection();
        $this->realisations = new ArrayCollection();
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthdate(): \DateTime
    {
        return $this->birthdate;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusType(): string
    {
        return $this->statusType;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @return array<int, Experience>
     */
    public function getExperiences(): array
    {
        return $this->experiences->toArray();
    }

    /**
     * @return array<int, Degree>
     */
    public function getDegrees(): array
    {
        return $this->degrees->toArray();
    }

    /**
     * @return array<int, Network>
     */
    public function getNetworks(): array
    {
        return $this->networks->toArray();
    }

    /**
     * @return array<int, Realisation>
     */
    public function getRealisations(): array
    {
        return $this->realisations->toArray();
    }

    public function getAge(): \DateInterval
    {
        return $this->age ?: $this->age = $this->getBirthdate()->diff(new \DateTime());
    }

    /**
     * La durée exacte d'expérience pro
     */
    public function getExperienceDuration(): \DateInterval
    {
        if (!$this->experienceDuration) {
            if ($firstExperience = $this->getFirstExperience()) {
                $this->experienceDuration = $firstExperience->getStartedAt()->diff(new \DateTime());
            } else {
                $this->experienceDuration = new \DateInterval('PT0S'); // 0 expérience
            }
        }

        return $this->experienceDuration;
    }

    /**
     * nb d'année d'expériences arrondi à l'année sup
     */
    public function getNbYearsOfXp(): int
    {
        $duration = $this->getExperienceDuration();

        return $duration->m >= 9 ? ++$duration->y : $duration->y;
    }

    /**
     * La 1ere expérience pro (rapport à la date de départ)
     */
    private function getFirstExperience(): ?Experience
    {
        // TODO : faire un vrai tri au cas ou l'order by change ?
        return $this->experiences->last() ?: null;
    }
}
