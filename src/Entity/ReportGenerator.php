<?php

namespace App\Entity;

use App\Repository\ReportGeneratorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass=ReportGeneratorRepository::class)
 */
class ReportGenerator
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
    private $clients;

    /**
     * @ORM\ManyToOne(targetEntity=Report::class, inversedBy="reportGenerators")
     */
    private $report;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="files_process", fileNameProperty="path")
     * @Assert\File(
     *   mimeTypes = {"text/plain"},
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
     * @ORM\OneToMany(targetEntity=ReportGeneratorSecond::class, mappedBy="reportGenerator")
     */
    private $reportGeneratorSeconds;

    /**
     * @var \DateTime $dateCreated
     *
     * @ORM\Column(name="date_created", type="datetime",nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $dateCreated;

    /**
     * @var \DateTime $dateLastModified
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date_last_modified", type="datetime",nullable=true)
     */
    private $dateLastModified;

    /**
     * @ORM\OneToMany(targetEntity=ReportLogo::class, mappedBy="reportGenerator",cascade={"persist", "remove"})
     */
    private $reportLogos;

    public function __construct()
    {
        $this->reportGeneratorSeconds = new ArrayCollection();
        $this->reportLogos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClients(): ?string
    {
        return $this->clients;
    }

    public function setClients(string $clients): self
    {
        $this->clients = $clients;

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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $file
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
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
            $reportGeneratorSecond->setReportGenerator($this);
        }

        return $this;
    }

    public function removeReportGeneratorSecond(ReportGeneratorSecond $reportGeneratorSecond): self
    {
        if ($this->reportGeneratorSeconds->removeElement($reportGeneratorSecond)) {
            // set the owning side to null (unless already changed)
            if ($reportGeneratorSecond->getReportGenerator() === $this) {
                $reportGeneratorSecond->setReportGenerator(null);
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

    /**
     * @return Collection|ReportLogo[]
     */
    public function getReportLogos(): Collection
    {
        return $this->reportLogos;
    }

    public function addReportLogo(ReportLogo $reportLogo): self
    {
        if (!$this->reportLogos->contains($reportLogo)) {
            $this->reportLogos[] = $reportLogo;
            $reportLogo->setReportGenerator($this);
        }

        return $this;
    }

    public function removeReportLogo(ReportLogo $reportLogo): self
    {
        if ($this->reportLogos->removeElement($reportLogo)) {
            // set the owning side to null (unless already changed)
            if ($reportLogo->getReportGenerator() === $this) {
                $reportLogo->setReportGenerator(null);
            }
        }

        return $this;
    }
}
