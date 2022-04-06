<?php

namespace App\Entity;

use App\Repository\ApCatalogModelBpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApCatalogModelBpRepository::class)
 */
class ApCatalogModelBp
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
     * @ORM\ManyToOne(targetEntity=ApCatalogCustomerBp::class, inversedBy="apCatalogModelBps")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $customer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive = 0;

    /**
     * @ORM\OneToMany(targetEntity=ApSectorBp::class, mappedBy="model", orphanRemoval=true)
     */
    private $apSectorBps;

    public function __construct()
    {
        $this->apSectorBps = new ArrayCollection();
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

    public function getCustomer(): ?ApCatalogCustomerBp
    {
        return $this->customer;
    }

    public function setCustomer(?ApCatalogCustomerBp $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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
     * @return Collection|ApSectorBp[]
     */
    public function getApSectorBps(): Collection
    {
        return $this->apSectorBps;
    }

    public function addApSectorBp(ApSectorBp $apSectorBp): self
    {
        if (!$this->apSectorBps->contains($apSectorBp)) {
            $this->apSectorBps[] = $apSectorBp;
            $apSectorBp->setModel($this);
        }

        return $this;
    }

    public function removeApSectorBp(ApSectorBp $apSectorBp): self
    {
        if ($this->apSectorBps->removeElement($apSectorBp)) {
            // set the owning side to null (unless already changed)
            if ($apSectorBp->getModel() === $this) {
                $apSectorBp->setModel(null);
            }
        }

        return $this;
    }
}
