<?php

namespace App\Entity;

use App\Repository\ResultMarkerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultMarkerRepository::class)
 */
class ResultMarker
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ResultSubsection::class, inversedBy="resultMarkers")
     */
    private $resultSubsection;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gene;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marker;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genotype;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $answers = [];

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private $bibliography;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResultSubsection(): ?ResultSubsection
    {
        return $this->resultSubsection;
    }

    public function setResultSubsection(?ResultSubsection $resultSubsection): self
    {
        $this->resultSubsection = $resultSubsection;

        return $this;
    }

    public function getGene(): ?string
    {
        return $this->gene;
    }

    public function setGene(?string $gene): self
    {
        $this->gene = $gene;

        return $this;
    }

    public function getMarker(): ?string
    {
        return $this->marker;
    }

    public function setMarker(?string $marker): self
    {
        $this->marker = $marker;

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

    public function getAnswers(): ?array
    {
        return $this->answers;
    }

    public function setAnswers(?array $answers): self
    {
        $this->answers = $answers;

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
}
