<?php

namespace App\Entity;

use App\Repository\ApCatalogCustomerBpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApCatalogCustomerBpRepository::class)
 */
class ApCatalogCustomerBp
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
     * @ORM\OneToMany(targetEntity=ApCatalogModelBp::class, mappedBy="customer")
     */
    private $apCatalogModelBps;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive = 0;

    public function __construct()
    {
        $this->apCatalogModelBps = new ArrayCollection();
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
     * @return Collection|ApCatalogModelBp[]
     */
    public function getApCatalogModelBps(): Collection
    {
        return $this->apCatalogModelBps;
    }

    public function addApCatalogModelBp(ApCatalogModelBp $apCatalogModelBp): self
    {
        if (!$this->apCatalogModelBps->contains($apCatalogModelBp)) {
            $this->apCatalogModelBps[] = $apCatalogModelBp;
            $apCatalogModelBp->setCustomer($this);
        }

        return $this;
    }

    public function removeApCatalogModelBp(ApCatalogModelBp $apCatalogModelBp): self
    {
        if ($this->apCatalogModelBps->removeElement($apCatalogModelBp)) {
            // set the owning side to null (unless already changed)
            if ($apCatalogModelBp->getCustomer() === $this) {
                $apCatalogModelBp->setCustomer(null);
            }
        }

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
