<?php

namespace App\Entity;

use App\Repository\ReportGeneratorSecondRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ReportGeneratorSecondRepository::class)
 */
class ReportGeneratorSecond
{   
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Report::class, inversedBy="reportGeneratorSeconds")
     */
    private $report;

    /**
     * @ORM\ManyToOne(targetEntity=ReportGenerator::class, inversedBy="reportGeneratorSeconds")
     */
    private $reportGenerator;

    /**
     * @ORM\OneToMany(targetEntity=ResultReport::class, mappedBy="reportGeneratorSecond",cascade={"persist", "remove"})
     */
    private $clientReports;

    /**
     * @var \DateTime $dateCreated
     *
     * @ORM\Column(name="date_created", type="datetime", nullable= true)
     * @Gedmo\Timestampable(on="create")
     */
    private $dateCreated;

    /**
     * @var \DateTime $dateLastModified
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date_last_modified", type="datetime", nullable= true)
     */
    private $dateLastModified;

    public function __construct()
    {
        $this->clientReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getReport(): ?Report
    {
        return $this->report;
    }

    public function setReport(?Report $report): self
    {
        $this->report = $report;

        return $this;
    }

    public function getReportGenerator(): ?ReportGenerator
    {
        return $this->reportGenerator;
    }

    public function setReportGenerator(?ReportGenerator $reportGenerator): self
    {
        $this->reportGenerator = $reportGenerator;

        return $this;
    }

    /**
     * @return Collection|ResultReport[]
     */
    public function getClientReports(): Collection
    {
        return $this->clientReports;
    }

    public function addClientReport(ResultReport $clientReport): self
    {
        if (!$this->clientReports->contains($clientReport)) {
            $this->clientReports[] = $clientReport;
            $clientReport->setReportGeneratorSecond($this);
        }

        return $this;
    }

    public function removeClientReport(ResultReport $clientReport): self
    {
        if ($this->clientReports->removeElement($clientReport)) {
            // set the owning side to null (unless already changed)
            if ($clientReport->getReportGeneratorSecond() === $this) {
                $clientReport->setReportGeneratorSecond(null);
            }
        }

        return $this;
    }

    public function getDateCreated(){
        return $this->dateCreated;
    }
    public function getDateLastModified(){
        return $this->dateLastModified;
    }

}
