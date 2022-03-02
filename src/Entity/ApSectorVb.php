<?php

namespace App\Entity;

use App\Repository\ApSectorVbRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApSectorVbRepository::class)
 */
class ApSectorVb
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
     * @ORM\ManyToOne(targetEntity=ApCatalogCaseVb::class, inversedBy="apSectorVbs")
     */
    private $caseId;

    /**
     * @ORM\OneToMany(targetEntity=ApCatalogFilesVb::class, mappedBy="sector")
     */
    private $apCatalogFilesVbs;

    public function __construct()
    {
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

    public function getCaseId(): ?ApCatalogCaseVb
    {
        return $this->caseId;
    }

    public function setCaseId(?ApCatalogCaseVb $caseId): self
    {
        $this->caseId = $caseId;

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
            $apCatalogFilesVb->setSector($this);
        }

        return $this;
    }

    public function removeApCatalogFilesVb(ApCatalogFilesVb $apCatalogFilesVb): self
    {
        if ($this->apCatalogFilesVbs->removeElement($apCatalogFilesVb)) {
            // set the owning side to null (unless already changed)
            if ($apCatalogFilesVb->getSector() === $this) {
                $apCatalogFilesVb->setSector(null);
            }
        }

        return $this;
    }
}
