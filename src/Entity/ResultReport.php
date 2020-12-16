<?php

namespace App\Entity;

use App\Repository\ResultReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=ResultReportRepository::class)
 */
class ResultReport
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
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=ResultSection::class, mappedBy="resultReport",cascade={"persist", "remove"})
     */
    private $resultSections;

    /**
     * @ORM\ManyToOne(targetEntity=ReportGeneratorSecond::class, inversedBy="clientReports")
     */
    private $reportGeneratorSecond;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showLogoJD;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="client_section", fileNameProperty="path")
     * @Assert\File(
     *    mimeTypes = {"image/jpeg", "image/png"},
     *   mimeTypesMessage = "Por favor adjunta un archivol valido",
     *   maxSize = "200M"
     * )
     *
     * @var File|null
     */
    protected $file;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     *
     * @var string|null
     */
    protected $path;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity=ReportLogo::class, inversedBy="resultReports")
     */
    private $reportLogo;



    public function __construct()
    {
        $this->resultSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|ResultSection[]
     */
    public function getResultSections(): Collection
    {
        return $this->resultSections;
    }

    public function addResultSection(ResultSection $resultSection): self
    {
        if (!$this->resultSections->contains($resultSection)) {
            $this->resultSections[] = $resultSection;
            $resultSection->setResultReport($this);
        }

        return $this;
    }

    public function removeResultSection(ResultSection $resultSection): self
    {
        if ($this->resultSections->removeElement($resultSection)) {
            // set the owning side to null (unless already changed)
            if ($resultSection->getResultReport() === $this) {
                $resultSection->setResultReport(null);
            }
        }

        return $this;
    }

    public function getReportGeneratorSecond(): ?ReportGeneratorSecond
    {
        return $this->reportGeneratorSecond;
    }

    public function setReportGeneratorSecond(?ReportGeneratorSecond $reportGeneratorSecond): self
    {
        $this->reportGeneratorSecond = $reportGeneratorSecond;

        return $this;
    }

    public function getShowLogoJD(): ?bool
    {
        return $this->showLogoJD;
    }

    public function setShowLogoJD(?bool $showLogoJD): self
    {
        $this->showLogoJD = $showLogoJD;

        return $this;
    }

     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updateAt = new \DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getReportLogo(): ?ReportLogo
    {
        return $this->reportLogo;
    }

    public function setReportLogo(?ReportLogo $reportLogo): self
    {
        $this->reportLogo = $reportLogo;

        return $this;
    }


}
