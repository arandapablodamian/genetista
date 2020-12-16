<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass=SectionRepository::class)
 */
class Section
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity=Subsection::class, inversedBy="sections")
     */
    private $subsections;

    /**
     * @ORM\OneToMany(targetEntity=SectionReport::class, mappedBy="section")
     */
    private $sectionReports;

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
     * @ORM\OneToMany(targetEntity=ResultSection::class, mappedBy="section")
     */
    private $resultSections;

    public function __construct()
    {
        $this->subsections = new ArrayCollection();
        $this->sectionReports = new ArrayCollection();
        $this->resultSections = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeSubsection(Subsection $subsection): self
    {
        $this->subsections->removeElement($subsection);

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
            $sectionReport->setSection($this);
        }

        return $this;
    }

    public function removeSectionReport(SectionReport $sectionReport): self
    {
        if ($this->sectionReports->removeElement($sectionReport)) {
            // set the owning side to null (unless already changed)
            if ($sectionReport->getSection() === $this) {
                $sectionReport->setSection(null);
            }
        }

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
            $resultSection->setSection($this);
        }

        return $this;
    }

    public function removeResultSection(ResultSection $resultSection): self
    {
        if ($this->resultSections->removeElement($resultSection)) {
            // set the owning side to null (unless already changed)
            if ($resultSection->getSection() === $this) {
                $resultSection->setSection(null);
            }
        }

        return $this;
    }
}
