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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=ApTab::class, inversedBy="parent")
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $apTab;

    /**
     * @ORM\OneToMany(targetEntity=ApTab::class, mappedBy="apTab")
     */
    private $parent;

    public function __construct()
    {
        $this->apAccesses = new ArrayCollection();
        $this->parent = new ArrayCollection();
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getApTab(): ?self
    {
        return $this->apTab;
    }

    public function setApTab(?self $apTab): self
    {
        $this->apTab = $apTab;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
            $parent->setApTab($this);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getApTab() === $this) {
                $parent->setApTab(null);
            }
        }

        return $this;
    }
}
