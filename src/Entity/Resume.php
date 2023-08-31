<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enums\ResumeStatus;
use App\Repository\ResumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
class Resume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTime $updatedAt = null;

    #[ORM\Column(length: 64)]
    protected ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected ?\DateTime $birthdate = null;

    /**
     * @ORM\Column(name="job_title", type="string", length=64)
     */
    #[ORM\Column(length: 64)]
    protected string $jobTitle;

    #[ORM\Column]
    protected string $status;

    #[ORM\Column(enumType: ResumeStatus::class)]
    protected ResumeStatus $statusType = ResumeStatus::AVAILABLE;

    #[ORM\Column]
    protected ?string $photo = null;

    #[ORM\Column(length: 64)]
    protected ?string $city = null;

    #[ORM\Column(length: 64)]
    protected ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'resume', targetEntity: Experience::class)]
    #[ORM\OrderBy(['startedAt' => 'DESC'])]
    protected Collection $experiences;

    #[ORM\OneToMany(mappedBy: 'resume', targetEntity: Degree::class)]
    #[ORM\OrderBy(['startedAt' => 'DESC'])]
    protected Collection $degrees;

    #[ORM\OneToMany(mappedBy: 'resume', targetEntity: Network::class)]
    #[ORM\OrderBy(['id' => 'DESC'])]
    protected Collection $networks;

    #[ORM\OneToMany(mappedBy: 'resume', targetEntity: Realisation::class)]
    #[ORM\OrderBy(['ordering' => 'DESC'])]
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

    public function getBirthdate(): ?\DateTime
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

    public function getStatusType(): ResumeStatus
    {
        return $this->statusType;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getEmail(): ?string
    {
        return $this->email;
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

    public function getAge(): ?\DateInterval
    {
        if (!$this->getBirthdate()) {
            return null;
        }

        return $this->age ?: $this->age = $this->getBirthdate()->diff(new \DateTime());
    }

    /**
     * La durée exacte d'expérience pro
     */
    public function getExperienceDuration(): \DateInterval
    {
        if (!$this->experienceDuration) {
            if (($firstExperience = $this->getFirstExperience()) && $firstExperience->getStartedAt()) {
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
