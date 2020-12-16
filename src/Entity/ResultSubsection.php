<?php

namespace App\Entity;

use App\Repository\ResultSubsectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultSubsectionRepository::class)
 */
class ResultSubsection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $markersFound;

    /**
     * @ORM\ManyToOne(targetEntity=Subsection::class, inversedBy="resultSubsections")
     * @ORM\JoinColumn(name="subsection_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $subsection;

    /**
     * @ORM\ManyToOne(targetEntity=ResultSection::class, inversedBy="resultSubsections")
     */
    private $resultSection;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bibliography;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $answers = [];

    /**
     * @ORM\Column(type="text", nullable=true,length=5000)
     */
    private $aditionalText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genotype;

    /**
     * @ORM\OneToMany(targetEntity=ResultMarker::class, mappedBy="resultSubsection",cascade={"persist", "remove"})
     */
    private $resultMarkers;

    public function __construct()
    {
        $this->resultMarkers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarkersFound(): ?string
    {
        return $this->markersFound;
    }

    public function setMarkersFound(string $markersFound): self
    {
        $this->markersFound = $markersFound;

        return $this;
    }

    public function getSubsection(): ?Subsection
    {
        return $this->subsection;
    }

    public function setSubsection(?Subsection $subsection): self
    {
        $this->subsection = $subsection;

        return $this;
    }

    public function getResultSection(): ?ResultSection
    {
        return $this->resultSection;
    }

    public function setResultSection(?ResultSection $resultSection): self
    {
        $this->resultSection = $resultSection;

        return $this;
    }

    public function getBibliography(): ?string
    {
        return $this->bibliography;
    }

    public function setBibliography(?string $bibliography): self
    {
        $this->bibliography = $bibliography;

        return $this;
    }

    public function getAnswers(): ?array
    {
        return $this->answers;
    }

    public function setAnswers(?array $answers): self
    {
        $this->answers = $answers;

        return $this;
    }

    public function getAditionalText(): ?string
    {
        return $this->aditionalText;
    }

    public function setAditionalText(?string $aditionalText): self
    {
        $this->aditionalText = $aditionalText;

        return $this;
    }

    public function getGen(): ?string
    {
        return $this->gen;
    }

    public function setGen(?string $gen): self
    {
        $this->gen = $gen;

        return $this;
    }

    public function getGenotype(): ?string
    {
        return $this->genotype;
    }

    public function setGenotype(?string $genotype): self
    {
        $this->genotype = $genotype;

        return $this;
    }

    /**
     * @return Collection|ResultMarker[]
     */
    public function getResultMarkers(): Collection
    {
        return $this->resultMarkers;
    }

    public function addResultMarker(ResultMarker $resultMarker): self
    {
        if (!$this->resultMarkers->contains($resultMarker)) {
            $this->resultMarkers[] = $resultMarker;
            $resultMarker->setResultSubsection($this);
        }

        return $this;
    }

    public function removeResultMarker(ResultMarker $resultMarker): self
    {
        if ($this->resultMarkers->removeElement($resultMarker)) {
            // set the owning side to null (unless already changed)
            if ($resultMarker->getResultSubsection() === $this) {
                $resultMarker->setResultSubsection(null);
            }
        }

        return $this;
    }
}
