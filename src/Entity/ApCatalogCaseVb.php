<?php

namespace App\Entity;

use App\Repository\ApCatalogCaseVbRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApCatalogCaseVbRepository::class)
 */
class ApCatalogCaseVb
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
     * @ORM\OneToMany(targetEntity=ApSectorVb::class, mappedBy="caseId")
     */
    private $apSectorVbs;

    /**
     * @ORM\OneToMany(targetEntity=ApCatalogFilesVb::class, mappedBy="caseId")
     */
    private $apCatalogFilesVbs;

    public function __construct()
    {
        $this->apSectorVbs = new ArrayCollection();
        $this->apCatalogFilesVbs = new ArrayCollection();
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

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * @return Collection|ApSectorVb[]
     */
    public function getApSectorVbs(): Collection
    {
        return $this->apSectorVbs;
    }

    public function addApSectorVb(ApSectorVb $apSectorVb): self
    {
        if (!$this->apSectorVbs->contains($apSectorVb)) {
            $this->apSectorVbs[] = $apSectorVb;
            $apSectorVb->setCaseId($this);
        }

        return $this;
    }

    public function removeApSectorVb(ApSectorVb $apSectorVb): self
    {
        if ($this->apSectorVbs->removeElement($apSectorVb)) {
            // set the owning side to null (unless already changed)
            if ($apSectorVb->getCaseId() === $this) {
                $apSectorVb->setCaseId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ApCatalogFilesVb[]
     */
    public function getApCatalogFilesVbs(): Collection
    {
        return $this->apCatalogFilesVbs;
    }

    public function addApCatalogFilesVb(ApCatalogFilesVb $apCatalogFilesVb): self
    {
        if (!$this->apCatalogFilesVbs->contains($apCatalogFilesVb)) {
            $this->apCatalogFilesVbs[] = $apCatalogFilesVb;
            $apCatalogFilesVb->setCaseId($this);
        }

        return $this;
    }

    public function removeApCatalogFilesVb(ApCatalogFilesVb $apCatalogFilesVb): self
    {
        if ($this->apCatalogFilesVbs->removeElement($apCatalogFilesVb)) {
            // set the owning side to null (unless already changed)
            if ($apCatalogFilesVb->getCaseId() === $this) {
                $apCatalogFilesVb->setCaseId(null);
            }
        }
        return $this;
    }
}
