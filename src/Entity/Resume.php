<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
    private $id;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthdate;

    /**
     * @ORM\Column(name="job_title", type="string", length=64, nullable=true)
     */
    protected $jobTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @ORM\Column(name="status_type", type="string", length=255, nullable=true)
     */
    protected $statusType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $photo;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $addr1;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $addr2;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    protected $zip;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    protected $telephone;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $about;

    /**
     * @ORM\OneToMany(targetEntity="Experience", mappedBy="resume")
     * @ORM\OrderBy({"startedAt" = "DESC"})
     */
    protected $experiences;

    /**
     * @ORM\OneToMany(targetEntity="Degree", mappedBy="resume")
     * @ORM\OrderBy({"startedAt" = "DESC"})
     */
    protected $degrees;

    /**
     * @ORM\OneToMany(targetEntity="Network", mappedBy="resume")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $networks;

    /**
     * @var \DateInterval age de la personne
     */
    private $age;

    /**
     * @var \DateInterval Durée experience
     */
    private $experienceDuration;

    public function __construct()
    {
        $this->experiences  = new ArrayCollection();
        $this->degrees      = new ArrayCollection();
        $this->networks     = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @return mixed
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getStatusType()
    {
        return $this->statusType;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return mixed
     */
    public function getAddr1()
    {
        return $this->addr1;
    }

    /**
     * @return mixed
     */
    public function getAddr2()
    {
        return $this->addr2;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @return mixed
     */
    public function getExperiences()
    {
        return $this->experiences;
    }

    /**
     * @return mixed
     */
    public function getDegrees()
    {
        return $this->degrees;
    }

    /**
     * @return mixed
     */
    public function getNetworks()
    {
        return $this->networks;
    }

    /**
     * @return \DateInterval
     * @throws \Exception
     */
    public function getAge()
    {
        // lazy
        if (!$this->age) {
            // birthdate needed
            if( !$this->getBirthdate()) {
                throw new \Exception('No birthdate !');
            }

            // Interval
            $this->age = $this->getBirthdate()->diff(new \DateTime(), true);
        }

        return $this->age;
    }

    /**
     * @return Experience La 1ere expérience pro (rapport à la date de départ)
     */
    private function getFirstExperience()
    {
        // TODO : faire un vrai tri au cas ou l'order by change ?
        return $this->getExperiences()->last();
    }

    /**
     * La durée exacte d'expérience pro
     *
     * @return \DateInterval durée de l'experience
     */
    public function getExperienceDuration()
    {
        // lazy
        if (!$this->experienceDuration) {
            if ($firstExperience = $this->getFirstExperience()) {
                $this->experienceDuration = $firstExperience->getStartedAt()->diff(new \DateTime(), true);
            } else {
                $this->experienceDuration = new \DateInterval('PT0S'); // 0 expérience (param obligatoire)
            }
        }

        return $this->experienceDuration;
    }

    /**
     * @return int nb d'année d'expériences arrondi à l'année sup
     */
    public function getNbYearsOfXp()
    {
        $duration = $this->getExperienceDuration();

        $nbYearsOfXp = $duration->y;

        return $duration->m >= 6 ? ++$nbYearsOfXp : $nbYearsOfXp;
    }
}
