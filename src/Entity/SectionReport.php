<?php

namespace App\Entity;

use App\Repository\SectionReportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectionReportRepository::class)
 */
class SectionReport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Section::class, inversedBy="sectionReports")
     */
    private $section;

    /**
     * @ORM\ManyToOne(targetEntity=Report::class, inversedBy="sectionReports")
     */
    private $report;

    public function __toString(){
        //return $this->section->__toString();
        return "N° Orden: {$this->orderNumber} \r\n - Sección: {$this->section->__toString()}";
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
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

    public function getReport(): ?Report
    {
        return $this->report;
    }

    public function setReport(?Report $report): self
    {
        $this->report = $report;

        return $this;
    }
}
