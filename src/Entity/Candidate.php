<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate extends User
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(options: ["default" => false])]
    private ?bool $isActive = null;

    #[ORM\ManyToMany(targetEntity: JobOffer::class, inversedBy: 'candidates')]
    private Collection $JobOffers;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cv = null;

    #[Vich\UploadableField(mapping: "candidate_cvs", fileNameProperty: "cv")]
    private ?File $cvFile = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $updatedAt = null;

    public function __construct()
    {
        $this->JobOffers = new ArrayCollection();
        $this->isActive = false;
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

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    public function setCvFile(File $cv = null)
    {
        $this->cvFile = $cv;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($cv) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }
}
