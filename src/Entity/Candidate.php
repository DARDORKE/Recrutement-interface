<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate extends User
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $cv = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToMany(targetEntity: JobOffer::class, inversedBy: 'candidates')]
    private Collection $JobOffers;

    public function __construct()
    {
        $this->JobOffers = new ArrayCollection();
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, JobOffer>
     */
    public function getJobOffers(): Collection
    {
        return $this->JobOffers;
    }

    public function addJobOffer(JobOffer $jobOffer): self
    {
        if (!$this->JobOffers->contains($jobOffer)) {
            $this->JobOffers->add($jobOffer);
        }

        return $this;
    }

    public function removeJobOffer(JobOffer $jobOffer): self
    {
        $this->JobOffers->removeElement($jobOffer);

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getFirstName().' '.$this->getLastName();
    }
}
