<?php

namespace App\Entity;

use App\Repository\ReportLogoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ReportLogoRepository::class)
 * @Vich\Uploadable
 */
class ReportLogo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showLogoJD = false;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="images_section", fileNameProperty="path")
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
     * @ORM\ManyToOne(targetEntity=ReportGenerator::class, inversedBy="reportLogos")
     */
    private $reportGenerator;

    /**
     * @ORM\OneToMany(targetEntity=ResultReport::class, mappedBy="reportLogo")
     */
    private $resultReports;

    public function __construct()
    {
        $this->resultReports = new ArrayCollection();
    }


    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShowLogoJD(): ?bool
    {
        return $this->showLogoJD;
    }

    public function setShowLogoJD(?bool $showLogoJD = false): self
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
     *     */
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
    public function getResultReports(): Collection
    {
        return $this->resultReports;
    }

    public function addResultReport(ResultReport $resultReport): self
    {
        if (!$this->resultReports->contains($resultReport)) {
            $this->resultReports[] = $resultReport;
            $resultReport->setReportLogo($this);
        }

        return $this;
    }

    public function removeResultReport(ResultReport $resultReport): self
    {
        if ($this->resultReports->removeElement($resultReport)) {
            // set the owning side to null (unless already changed)
            if ($resultReport->getReportLogo() === $this) {
                $resultReport->setReportLogo(null);
            }
        }

        return $this;
    }
  
}
