<?php

namespace App\Entity;

use App\Repository\ApCatalogFilesVbRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApCatalogFilesVbRepository::class)
 */
class ApCatalogFilesVb
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="apCatalogFilesVbs")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=ApCatalogCaseVb::class, inversedBy="apCatalogFilesVbs")
     */
    private $caseId;

    /**
     * @ORM\ManyToOne(targetEntity=ApSectorVb::class, inversedBy="apCatalogFilesVbs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sector;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $file_size;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $file_type;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCaseId(): ?ApCatalogCaseVb
    {
        return $this->caseId;
    }

    public function setCaseId(?ApCatalogCaseVb $caseId): self
    {
        $this->caseId = $caseId;

        return $this;
    }

    public function getSector(): ?ApSectorVb
    {
        return $this->sector;
    }

    public function setSector(?ApSectorVb $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->file_size;
    }

    public function setFileSize(int $file_size): self
    {
        $this->file_size = $file_size;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->file_type;
    }

    public function setFileType(string $file_type): self
    {
        $this->file_type = $file_type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
