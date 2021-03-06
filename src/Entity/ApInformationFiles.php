<?php

namespace App\Entity;

use App\Repository\ApInformationFilesRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=ApInformationFilesRepository::class)
 * @Vich\Uploadable
 */
class ApInformationFiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ApInformationSection::class, inversedBy="apInformationFiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Section;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @Vich\UploadableField(mapping="information_files", fileNameProperty="fileName")
     * @var File
     * @Assert\File(
     * maxSize = "10M",
     * maxSizeMessage = "Le fichier est trop lourd ({{ size }} {{ suffix }}). Maximum: {{ limit }} {{ suffix }}",
     * mimeTypes = {"application/pdf", "application/x-pdf"},
     * mimeTypesMessage = "Uploader un fichier PDF valide SVP"
     * )
     */
    private $imageFile;


    /**
     * @ORM\Column(type="integer")
     */
    private $FileSize;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FileType;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Archive = 0;

    /**
     * @ORM\OneToMany(targetEntity=ApInformationParapher::class, mappedBy="fileId")
     */
    private $apInformationParaphers;

    /**
     * @ORM\OneToMany(targetEntity=ApInformationSignature::class, mappedBy="file")
     */
    private $apInformationSignatures;

    /**
     * @ORM\OneToMany(targetEntity=ApInformationViewed::class, mappedBy="file")
     */
    private $apInformationVieweds;

    public function __construct()
    {
        $this->apInformationParaphers = new ArrayCollection();
        $this->apInformationSignatures = new ArrayCollection();
        $this->apInformationVieweds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSection(): ?ApInformationSection
    {
        return $this->Section;
    }

    public function setSection(?ApInformationSection $Section): self
    {
        $this->Section = $Section;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

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
        return $this->FileSize;
    }

    public function setFileSize(int $FileSize): self
    {
        $this->FileSize = $FileSize;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->FileType;
    }

    public function setFileType(string $FileType): self
    {
        $this->FileType = $FileType;

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

    public function getArchive(): ?bool
    {
        return $this->Archive;
    }

    public function setArchive(bool $Archive): self
    {
        $this->Archive = $Archive;

        return $this;
    }

    /**
     * @return Collection<int, ApInformationParapher>
     */
    public function getApInformationParaphers(): Collection
    {
        return $this->apInformationParaphers;
    }

    public function addApInformationParapher(ApInformationParapher $apInformationParapher): self
    {
        if (!$this->apInformationParaphers->contains($apInformationParapher)) {
            $this->apInformationParaphers[] = $apInformationParapher;
            $apInformationParapher->setFileId($this);
        }

        return $this;
    }

    public function removeApInformationParapher(ApInformationParapher $apInformationParapher): self
    {
        if ($this->apInformationParaphers->removeElement($apInformationParapher)) {
            // set the owning side to null (unless already changed)
            if ($apInformationParapher->getFileId() === $this) {
                $apInformationParapher->setFileId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApInformationSignature>
     */
    public function getApInformationSignatures(): Collection
    {
        return $this->apInformationSignatures;
    }

    public function addApInformationSignature(ApInformationSignature $apInformationSignature): self
    {
        if (!$this->apInformationSignatures->contains($apInformationSignature)) {
            $this->apInformationSignatures[] = $apInformationSignature;
            $apInformationSignature->setFile($this);
        }

        return $this;
    }

    public function removeApInformationSignature(ApInformationSignature $apInformationSignature): self
    {
        if ($this->apInformationSignatures->removeElement($apInformationSignature)) {
            // set the owning side to null (unless already changed)
            if ($apInformationSignature->getFile() === $this) {
                $apInformationSignature->setFile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApInformationViewed>
     */
    public function getApInformationVieweds(): Collection
    {
        return $this->apInformationVieweds;
    }

    public function addApInformationViewed(ApInformationViewed $apInformationViewed): self
    {
        if (!$this->apInformationVieweds->contains($apInformationViewed)) {
            $this->apInformationVieweds[] = $apInformationViewed;
            $apInformationViewed->setFile($this);
        }

        return $this;
    }

    public function removeApInformationViewed(ApInformationViewed $apInformationViewed): self
    {
        if ($this->apInformationVieweds->removeElement($apInformationViewed)) {
            // set the owning side to null (unless already changed)
            if ($apInformationViewed->getFile() === $this) {
                $apInformationViewed->setFile(null);
            }
        }

        return $this;
    }
}
