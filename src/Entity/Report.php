<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
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
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=ReportGenerator::class, mappedBy="report")
     */
    private $reportGenerators;

    /**
     * @ORM\OneToMany(targetEntity=SectionReport::class, mappedBy="report",cascade={"persist", "remove"})
     */
    private $sectionReports;

    /**
     * @ORM\OneToMany(targetEntity=ReportGeneratorSecond::class, mappedBy="report")
     */
    private $reportGeneratorSeconds;

    public function __construct()
    {
        $this->reportGenerators = new ArrayCollection();
        $this->sectionReports = new ArrayCollection();
        $this->reportGeneratorSeconds = new ArrayCollection();
    }

    public function __toString(){
        return ($this->title) ? $this->title : '' ;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @return Collection|ReportGenerator[]
     */
    public function getReportGenerators(): Collection
    {
        return $this->reportGenerators;
    }

    public function addReportGenerator(ReportGenerator $reportGenerator): self
    {
        if (!$this->reportGenerators->contains($reportGenerator)) {
            $this->reportGenerators[] = $reportGenerator;
            $reportGenerator->setReport($this);
        }

        return $this;
    }

    public function removeReportGenerator(ReportGenerator $reportGenerator): self
    {
        if ($this->reportGenerators->removeElement($reportGenerator)) {
            // set the owning side to null (unless already changed)
            if ($reportGenerator->getReport() === $this) {
                $reportGenerator->setReport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SectionReport[]
     */
    public function getSectionReports(): Collection
    {
        return $this->sectionReports;
    }

    public function addSectionReport(SectionReport $sectionReport): self
    {
        if (!$this->sectionReports->contains($sectionReport)) {
            $this->sectionReports[] = $sectionReport;
            $sectionReport->setReport($this);
        }

        return $this;
    }

    public function removeSectionReport(SectionReport $sectionReport): self
    {
        if ($this->sectionReports->removeElement($sectionReport)) {
            // set the owning side to null (unless already changed)
            if ($sectionReport->getReport() === $this) {
                $sectionReport->setReport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReportGeneratorSecond[]
     */
    public function getReportGeneratorSeconds(): Collection
    {
        return $this->reportGeneratorSeconds;
    }

    public function addReportGeneratorSecond(ReportGeneratorSecond $reportGeneratorSecond): self
    {
        if (!$this->reportGeneratorSeconds->contains($reportGeneratorSecond)) {
            $this->reportGeneratorSeconds[] = $reportGeneratorSecond;
            $reportGeneratorSecond->setReport($this);
        }

        return $this;
    }

    public function removeReportGeneratorSecond(ReportGeneratorSecond $reportGeneratorSecond): self
    {
        if ($this->reportGeneratorSeconds->removeElement($reportGeneratorSecond)) {
            // set the owning side to null (unless already changed)
            if ($reportGeneratorSecond->getReport() === $this) {
                $reportGeneratorSecond->setReport(null);
            }
        }

        return $this;
    }
}
