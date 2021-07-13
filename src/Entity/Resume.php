<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResumeRepository")
 * @ORM\Table(name="resume")
 */
class Resume
{
    const STATUS_TYPE_AVAILABLE = 'available';
    const STATUS_TYPE_BUSY = 'busy';

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
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected ?string $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected \DateTime $birthdate;

    /**
     * @ORM\Column(name="job_title", type="string", length=64, nullable=true)
     */
    protected ?string $jobTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $status;

    /**
     * @ORM\Column(name="status_type", type="string", length=255, nullable=true)
     */
    protected ?string $statusType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $photo;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected ?string$addr1;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected ?string$addr2;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    protected ?string $zip;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected ?string $city;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    protected ?string $telephone;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected ?string $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected ?string $about;

    /**
     * @ORM\OneToMany(targetEntity="Experience", mappedBy="resume")
     * @ORM\OrderBy({"startedAt" = "DESC"})
     */
    protected Collection $experiences;

    /**
     * @ORM\OneToMany(targetEntity="Degree", mappedBy="resume")
     * @ORM\OrderBy({"startedAt" = "DESC"})
     */
    protected Collection $degrees;

    /**
     * @ORM\OneToMany(targetEntity="Network", mappedBy="resume")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected Collection $networks;

    /**
     * @ORM\OneToMany(targetEntity="Realisation", mappedBy="resume")
     * @ORM\OrderBy({"ordering" = "ASC"})
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getBirthdate(): \DateTime
    {
        return $this->birthdate;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getStatusType(): ?string
    {
        return $this->statusType;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function getAddr1(): ?string
    {
        return $this->addr1;
    }

    public function getAddr2(): ?string
    {
        return $this->addr2;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function getExperiences(): array
    {
        return $this->experiences->toArray();
    }

    public function getDegrees(): array
    {
        return $this->degrees->toArray();
    }

    public function getNetworks(): array
    {
        return $this->networks->toArray();
    }

    public function getRealisations(): array
    {
        return $this->realisations->toArray();
    }

    public function getAge(): \DateInterval
    {
        if (!$this->age) {
            // birthdate needed
            if (!$this->getBirthdate()) {
                throw new \Exception('No birthdate to calcul age !');
            }

            // Interval
            $this->age = $this->getBirthdate()->diff(new \DateTime(), true);
        }

        return $this->age;
    }

    /**
     * La durée exacte d'expérience pro
     */
    public function getExperienceDuration(): \DateInterval
    {
        if (!$this->experienceDuration) {
            if ($firstExperience = $this->getFirstExperience()) {
                $this->experienceDuration = $firstExperience->getStartedAt()->diff(new \DateTime(), true);
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

        $nbYearsOfXp = $duration->y;

        return $duration->m >= 6 ? ++$nbYearsOfXp : $nbYearsOfXp;
    }

    /**
     * La 1ere expérience pro (rapport à la date de départ)
     */
    private function getFirstExperience(): Experience
    {
        // TODO : faire un vrai tri au cas ou l'order by change ?
        return $this->experiences->last();
    }
}
