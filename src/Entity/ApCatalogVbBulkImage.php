<?php

namespace App\Entity;

use App\Repository\ApCatalogVbBulkImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ApCatalogVbBulkImageRepository::class)
 * @Vich\Uploadable
 * 
 */
class ApCatalogVbBulkImage
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="apCatalogVbBulkImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=ApCatalogCaseVb::class, inversedBy="apCatalogVbBulkImages")
     */
    private $caseIs;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file_name;

    /**
     * @Vich\UploadableField(mapping="model_vb_files", fileNameProperty="file_name")
     * @var File
     * @Assert\File(
     * maxSize = "10M",
     * maxSizeMessage = "Le fichier est trop lourd ({{ size }} {{ suffix }}). Maximum: {{ limit }} {{ suffix }}",
     * mimeTypes = {"image/jp2", "image/jpg", "image/jpeg", "image/png"},
     * mimeTypesMessage = "Upload de fichier JPEG ou JPG valide"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="integer")
     */
    private $file_size;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file_type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $miniature;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCaseIs(): ?ApCatalogCaseVb
    {
        return $this->caseIs;
    }

    public function setCaseIs(?ApCatalogCaseVb $caseIs): self
    {
        $this->caseIs = $caseIs;

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

    public function setFileName(?string $file_name): self
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function setImageFile(?File $file_name = null)
    {
        $this->imageFile = $file_name;

        if (null !== $file_name) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getMiniature(): ?bool
    {
        return $this->miniature;
    }

    public function setMiniature(bool $miniature): self
    {
        $this->miniature = $miniature;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
