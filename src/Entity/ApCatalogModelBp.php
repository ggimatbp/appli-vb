<?php

namespace App\Entity;

use App\Repository\ApCatalogModelBpRepository;
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
}
