<?php

namespace App\Entity;

use App\Repository\SubsectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubsectionRepository::class)
 */
class Subsection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $title;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAutomatic;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $markers;

    /**
     * @ORM\ManyToMany(targetEntity=Answer::class, inversedBy="subsections")
     */
    private $answers;

    /**
     * @ORM\ManyToMany(targetEntity=Section::class, mappedBy="subsections")
     */
    private $sections;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $bibliography;

    /**
     * @ORM\OneToMany(targetEntity=ResultSubsection::class, mappedBy="subsection")
     */
    private $resultSubsections;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->resultSubsections = new ArrayCollection();
    }

    public function __toString(){
        return $this->title;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIsAutomatic(): ?bool
    {
        return $this->isAutomatic;
    }

    public function setIsAutomatic(bool $isAutomatic): self
    {
        $this->isAutomatic = $isAutomatic;

        return $this;
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

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        $this->answers->removeElement($answer);

        return $this;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->addSubsection($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            $section->removeSubsection($this);
        }

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
            $resultSubsection->setSubsection($this);
        }

        return $this;
    }

    public function removeResultSubsection(ResultSubsection $resultSubsection): self
    {
        if ($this->resultSubsections->removeElement($resultSubsection)) {
            // set the owning side to null (unless already changed)
            if ($resultSubsection->getSubsection() === $this) {
                $resultSubsection->setSubsection(null);
            }
        }

        return $this;
    }
}
