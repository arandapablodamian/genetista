<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
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
    private $answer;

    /**
     * @ORM\ManyToMany(targetEntity=Subsection::class, mappedBy="answers")
     */
    private $subsections;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptiveAnswer;


    public function __construct()
    {
        $this->subsections = new ArrayCollection();
    }

    public  function __toString(){
        return "{$this->answer} - {$this->descriptiveAnswer}";
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return Collection|Subsection[]
     */
    public function getSubsections(): Collection
    {
        return $this->subsections;
    }

    public function addSubsection(Subsection $subsection): self
    {
        if (!$this->subsections->contains($subsection)) {
            $this->subsections[] = $subsection;
            $subsection->addAnswer($this);
        }

        return $this;
    }

    public function removeSubsection(Subsection $subsection): self
    {
        if ($this->subsections->removeElement($subsection)) {
            $subsection->removeAnswer($this);
        }

        return $this;
    }

    public function getDescriptiveAnswer(): ?string
    {
        return $this->descriptiveAnswer;
    }

    public function setDescriptiveAnswer(string $descriptiveAnswer): self
    {
        $this->descriptiveAnswer = $descriptiveAnswer;

        return $this;
    }

    
}
