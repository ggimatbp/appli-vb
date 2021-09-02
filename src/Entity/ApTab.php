<?php

namespace App\Entity;

use App\Repository\ApTabRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApTabRepository::class)
 */
class ApTab
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
     * @ORM\OneToMany(targetEntity=ApAccess::class, mappedBy="tab")
     */
    private $apAccesses;

    public function __construct()
    {
        $this->apAccesses = new ArrayCollection();
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
     * @return Collection|ApAccess[]
     */
    public function getApAccesses(): Collection
    {
        return $this->apAccesses;
    }

    public function addApAccess(ApAccess $apAccess): self
    {
        if (!$this->apAccesses->contains($apAccess)) {
            $this->apAccesses[] = $apAccess;
            $apAccess->setTab($this);
        }

        return $this;
    }

    public function removeApAccess(ApAccess $apAccess): self
    {
        if ($this->apAccesses->removeElement($apAccess)) {
            // set the owning side to null (unless already changed)
            if ($apAccess->getTab() === $this) {
                $apAccess->setTab(null);
            }
        }

        return $this;
    }
}
