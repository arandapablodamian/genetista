<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultRepository::class)
 */
class Result
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

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
     * @ORM\Column(type="string",length=5000, nullable=true)
     */
    private $result;

    /**
     * @ORM\Column(type="text", nullable=true,length=5000)
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true,length=5000)
     */
    private $Biography;

    /**
     * @ORM\Column(type="text", nullable=true,length=5000)
     */
    private $descriptiveResult;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getDescriptiveResult(): ?string
    {
        return $this->descriptiveResult;
    }

    public function setDescriptiveResult(?string $descriptiveResult): self
    {
        $this->descriptiveResult = $descriptiveResult;

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

    public function getBiography(): ?string
    {
        return $this->Biography;
    }

    public function setBiography(?string $Biography): self
    {
        $this->Biography = $Biography;

        return $this;
    }
}
