<?php

namespace App\Entity;

use App\Repository\ResultSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultSectionRepository::class)
 */
class ResultSection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Section::class, inversedBy="resultSections")
     */
    private $section;

    /**
     * @ORM\OneToMany(targetEntity=ResultSubsection::class, mappedBy="resultSection",cascade={"persist", "remove"})
     */
    private $resultSubsections;

    /**
     * @ORM\ManyToOne(targetEntity=ResultReport::class, inversedBy="resultSections")
     */
    private $resultReport;

    /**
     * @ORM\Column(type="text", nullable=true,length=5000)
     */
    private $note;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderNumber;

    public function __construct()
    {
        $this->resultSubsections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return Collection|ResultSubsection[]
     */
    public function getResultSubsections(): Collection
    {
        return $this->resultSubsections;
    }

    public function addResultSubsection(ResultSubsection $resultSubsection): self
    {
        if (!$this->resultSubsections->contains($resultSubsection)) {
            $this->resultSubsections[] = $resultSubsection;
            $resultSubsection->setResultSection($this);
        }

        return $this;
    }

    public function removeResultSubsection(ResultSubsection $resultSubsection): self
    {
        if ($this->resultSubsections->removeElement($resultSubsection)) {
            // set the owning side to null (unless already changed)
            if ($resultSubsection->getResultSection() === $this) {
                $resultSubsection->setResultSection(null);
            }
        }

        return $this;
    }

    public function getResultReport(): ?ResultReport
    {
        return $this->resultReport;
    }

    public function setResultReport(?ResultReport $resultReport): self
    {
        $this->resultReport = $resultReport;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(?int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }
}
