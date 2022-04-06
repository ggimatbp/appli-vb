<?php

namespace App\Entity;

use App\Repository\ApSectorBpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApSectorBpRepository::class)
 */
class ApSectorBp
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
    * @ORM\Column(type="boolean")
    */
    private $archive = 0;


    /**
     * @ORM\OneToMany(targetEntity=ApCatalogFilesBp::class, mappedBy="relation")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=ApCatalogModelBp::class, inversedBy="apSectorBps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $model;

    public function __construct()
    {
        $this->file = new ArrayCollection();
    }

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

    /**
     * @return Collection|ApCatalogFilesBp[]
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    public function addFile(ApCatalogFilesBp $file): self
    {
        if (!$this->file->contains($file)) {
            $this->file[] = $file;
            $file->setRelation($this);
        }

        return $this;
    }

    public function removeFile(ApCatalogFilesBp $file): self
    {
        if ($this->file->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getRelation() === $this) {
                $file->setRelation(null);
            }
        }

        return $this;
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

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
