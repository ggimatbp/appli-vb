<?php

namespace App\Entity;

use App\Repository\ApCatalogFilesBpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass=ApCatalogFilesBpRepository::class)
 * @Vich\Uploadable
*/
class ApCatalogFilesBp
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ApCatalogModelBp::class, inversedBy="apCatalogFilesBps")
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @Vich\UploadableField(mapping="model_bp_files", fileNameProperty="fileName")
     * @var File
     * @Assert\File(
     * maxSize = "10M",
     * mimeTypes = {"application/pdf", "application/x-pdf", "image/jp2", "image/jpg", "image/jpeg", "image/png"},
     * mimeTypesMessage = "Fichier invalide. Format accepté: PDF, JPG, JPEG, PNG",
     * maxSizeMessage = "Le fichier est trop lourd ({{ size }} {{ suffix }}). Maximum: {{ limit }} {{ suffix }}",
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="integer")
     */
    private $fileSize;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $fileType;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="apCatalogFilesBps")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive = 0;

    /**
     * @ORM\ManyToOne(targetEntity=ApSectorBp::class, inversedBy="file")
     */
    private $relation;

    public function __construct()
    {
        $this->apCatalogFilesBpHistories = new ArrayCollection();
        $this->parent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getModel(): ?ApCatalogModelBp
    {
        return $this->model;
    }

    public function setModel(?ApCatalogModelBp $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function setImageFile(?File $fileName = null)
    {
        $this->imageFile = $fileName;

        if (null !== $fileName) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType): self
    {
        $this->fileType = $fileType;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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

    // /**
    //  * @return Collection|ApCatalogFilesBpHistory[]
    //  */
    // public function getApCatalogFilesBpHistories(): Collection
    // {
    //     return $this->apCatalogFilesBpHistories;
    // }

    // public function addApCatalogFilesBpHistory(ApCatalogFilesBpHistory $apCatalogFilesBpHistory): self
    // {
    //     if (!$this->apCatalogFilesBpHistories->contains($apCatalogFilesBpHistory)) {
    //         $this->apCatalogFilesBpHistories[] = $apCatalogFilesBpHistory;
    //         $apCatalogFilesBpHistory->setFile($this);
    //     }

    //     return $this;
    // }

    // public function removeApCatalogFilesBpHistory(ApCatalogFilesBpHistory $apCatalogFilesBpHistory): self
    // {
    //     if ($this->apCatalogFilesBpHistories->removeElement($apCatalogFilesBpHistory)) {
    //         // set the owning side to null (unless already changed)
    //         if ($apCatalogFilesBpHistory->getFile() === $this) {
    //             $apCatalogFilesBpHistory->setFile(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getRelation(): ?ApSectorBp
    {
        return $this->relation;
    }

    public function setRelation(?ApSectorBp $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getSon(): ?self
    {
        return $this->son;
    }

    public function setSon(?self $son): self
    {
        $this->son = $son;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
            $parent->setSon($this);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getSon() === $this) {
                $parent->setSon(null);
            }
        }

        return $this;
    }

}
