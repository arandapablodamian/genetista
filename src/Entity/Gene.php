<?php

namespace App\Entity;

use App\Repository\GeneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GeneRepository::class)
 */
class Gene
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $markers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genotype;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarkers(): ?string
    {
        return $this->markers;
    }

    public function setMarkers(string $markers): self
    {
        $this->markers = $markers;

        return $this;
    }

    public function getGenotype(): ?string
    {
        return $this->genotype;
    }

    public function setGenotype(string $genotype): self
    {
        $this->genotype = $genotype;

        return $this;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(string $person): self
    {
        $this->person = $person;

        return $this;
    }
}
