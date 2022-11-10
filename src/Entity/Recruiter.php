<?php

namespace App\Entity;

use App\Repository\RecruiterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecruiterRepository::class)]
class Recruiter extends User
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'recruiter', targetEntity: JobOffer::class, orphanRemoval: true)]
    private Collection $JobOffers;

    public function __construct()
    {
        $this->JobOffers = new ArrayCollection();
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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
            $jobOffer->setRecruiter($this);
        }

        return $this;
    }

    public function removeJobOffer(JobOffer $jobOffer): self
    {
        if ($this->JobOffers->removeElement($jobOffer)) {
            // set the owning side to null (unless already changed)
            if ($jobOffer->getRecruiter() === $this) {
                $jobOffer->setRecruiter(null);
            }
        }

        return $this;
    }
}
