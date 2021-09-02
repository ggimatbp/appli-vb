<?php

namespace App\Entity;

use App\Repository\ApRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApRoleRepository::class)
 */
class ApRole
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
     * @ORM\OneToMany(targetEntity=ApAccess::class, mappedBy="role")
     */
    private $apAccesses;

    /**
     * @ORM\OneToMany(targetEntity=ApEmployee::class, mappedBy="Role")
     */
    private $apEmployees;

    public function __construct()
    {
        $this->apAccesses = new ArrayCollection();
        $this->apEmployees = new ArrayCollection();
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
            $apAccess->setRole($this);
        }

        return $this;
    }

    public function removeApAccess(ApAccess $apAccess): self
    {
        if ($this->apAccesses->removeElement($apAccess)) {
            // set the owning side to null (unless already changed)
            if ($apAccess->getRole() === $this) {
                $apAccess->setRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ApEmployee[]
     */
    public function getApEmployees(): Collection
    {
        return $this->apEmployees;
    }

    public function addApEmployee(ApEmployee $apEmployee): self
    {
        if (!$this->apEmployees->contains($apEmployee)) {
            $this->apEmployees[] = $apEmployee;
            $apEmployee->setRole($this);
        }

        return $this;
    }

    public function removeApEmployee(ApEmployee $apEmployee): self
    {
        if ($this->apEmployees->removeElement($apEmployee)) {
            // set the owning side to null (unless already changed)
            if ($apEmployee->getRole() === $this) {
                $apEmployee->setRole(null);
            }
        }

        return $this;
    }
}
