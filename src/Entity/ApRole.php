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
    public $name;

    /**
     * @ORM\OneToMany(targetEntity=ApAccess::class, cascade={"persist"}, mappedBy="role")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $apAccesses;

    /**
     * @ORM\OneToMany(targetEntity=ApEmployee::class, mappedBy="Role")
     */
    private $apEmployees;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="roleId")
     */
    private $users;

    public function __construct()
    {
        $this->apAccesses = new ArrayCollection();
        $this->apEmployees = new ArrayCollection();
        $this->users = new ArrayCollection();
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
        $this->name = strtoupper($name);

        return $this;
    }

    /**
     * @return Collection|ApAccess[]
     */
    public function getApAccesses(): Collection
    {
        return $this->apAccesses;
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setRoleId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getRoleId() === $this) {
                $user->setRoleId(null);
            }
        }

        return $this;
    }

}
