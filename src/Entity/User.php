<?php

namespace App\Entity;


use App\Entity\ApRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=apRole::class, inversedBy="users")
     */
    private $roleId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=ApCatalogFilesBp::class, mappedBy="user")
     */
    private $apCatalogFilesBps;

    /**
     * @ORM\OneToMany(targetEntity=ApCatalogFilesVb::class, mappedBy="user")
     */
    private $apCatalogFilesVbs;

    /**
     * @ORM\OneToMany(targetEntity=ApInformationParapher::class, mappedBy="User")
     */
    private $apInformationParaphers;

    /**
     * @ORM\OneToMany(targetEntity=ApCatalogVbBulkImage::class, mappedBy="user")
     */
    private $apCatalogVbBulkImages;

    /**
     * @ORM\OneToMany(targetEntity=ApInformationSignature::class, mappedBy="user")
     */
    private $apInformationSignatures;

    /**
     * @ORM\OneToMany(targetEntity=ApInformationViewed::class, mappedBy="user")
     */
    private $apInformationVieweds;


    // /**
    //  * @ORM\OneToMany(targetEntity=ApCatalogFilesBpHistory::class, mappedBy="user")
    //  */
    // private $apCatalogFilesBpHistories;

    public function __construct()
    {
        $this->apCatalogFilesBps = new ArrayCollection();
        $this->apCatalogFilesBpHistories = new ArrayCollection();
        $this->apCatalogFilesVbs = new ArrayCollection();
        $this->logs = new ArrayCollection();
        $this->apInformationParaphers = new ArrayCollection();
        $this->apCatalogVbBulkImages = new ArrayCollection();
        $this->apInformationSignatures = new ArrayCollection();
        $this->apInformationVieweds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;

    }

    public function setRoles(string $roles): self
    {
        
        $this->roles = ["ROLE_$roles", "ROLE_LAMBDA"];
            
        return $this;
        
    }

    public function setNoRoles(): self
    {
        
        $this->roles = [""];
            
        return $this;
        
    }  

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRoleId(): ?apRole
    {
        return $this->roleId;
    }

    public function setRoleId(?apRole $roleId): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getTheme(): ?int
    {
        return $this->theme;
    }

    public function setTheme(?int $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection|ApCatalogFilesBp[]
     */
    public function getApCatalogFilesBps(): Collection
    {
        return $this->apCatalogFilesBps;
    }

    public function addApCatalogFilesBp(ApCatalogFilesBp $apCatalogFilesBp): self
    {
        if (!$this->apCatalogFilesBps->contains($apCatalogFilesBp)) {
            $this->apCatalogFilesBps[] = $apCatalogFilesBp;
            $apCatalogFilesBp->setUser($this);
        }

        return $this;
    }

    public function removeApCatalogFilesBp(ApCatalogFilesBp $apCatalogFilesBp): self
    {
        if ($this->apCatalogFilesBps->removeElement($apCatalogFilesBp)) {
            // set the owning side to null (unless already changed)
            if ($apCatalogFilesBp->getUser() === $this) {
                $apCatalogFilesBp->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->lastname;
    }

    // /**
    //  * @return Collection|ApCatalogFilesBpHistory[]
    //  */
    // public function getApCatalogFilesBpHistories(): Collection
    // {
    //     return $this->apCatalogFilesBpHistories;
    // }

    // public function addApCatalogFilesBpHistory(ApCatalogFilesBpHistory $apCatalogFilesBpHistory): self
    // {
    //     if (!$this->apCatalogFilesBpHistories->contains($apCatalogFilesBpHistory)) {
    //         $this->apCatalogFilesBpHistories[] = $apCatalogFilesBpHistory;
    //         $apCatalogFilesBpHistory->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeApCatalogFilesBpHistory(ApCatalogFilesBpHistory $apCatalogFilesBpHistory): self
    // {
    //     if ($this->apCatalogFilesBpHistories->removeElement($apCatalogFilesBpHistory)) {
    //         // set the owning side to null (unless already changed)
    //         if ($apCatalogFilesBpHistory->getUser() === $this) {
    //             $apCatalogFilesBpHistory->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

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
            $apCatalogFilesVb->setUser($this);
        }

        return $this;
    }

    public function removeApCatalogFilesVb(ApCatalogFilesVb $apCatalogFilesVb): self
    {
        if ($this->apCatalogFilesVbs->removeElement($apCatalogFilesVb)) {
            // set the owning side to null (unless already changed)
            if ($apCatalogFilesVb->getUser() === $this) {
                $apCatalogFilesVb->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApInformationParapher>
     */
    public function getApInformationParaphers(): Collection
    {
        return $this->apInformationParaphers;
    }

    public function addApInformationParapher(ApInformationParapher $apInformationParapher): self
    {
        if (!$this->apInformationParaphers->contains($apInformationParapher)) {
            $this->apInformationParaphers[] = $apInformationParapher;
            $apInformationParapher->setUser($this);
        }

        return $this;
    }

    public function removeApInformationParapher(ApInformationParapher $apInformationParapher): self
    {
        if ($this->apInformationParaphers->removeElement($apInformationParapher)) {
            // set the owning side to null (unless already changed)
            if ($apInformationParapher->getUser() === $this) {
                $apInformationParapher->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApCatalogVbBulkImage>
     */
    public function getApCatalogVbBulkImages(): Collection
    {
        return $this->apCatalogVbBulkImages;
    }

    public function addApCatalogVbBulkImage(ApCatalogVbBulkImage $apCatalogVbBulkImage): self
    {
        if (!$this->apCatalogVbBulkImages->contains($apCatalogVbBulkImage)) {
            $this->apCatalogVbBulkImages[] = $apCatalogVbBulkImage;
            $apCatalogVbBulkImage->setUser($this);
        }

        return $this;
    }

    public function removeApCatalogVbBulkImage(ApCatalogVbBulkImage $apCatalogVbBulkImage): self
    {
        if ($this->apCatalogVbBulkImages->removeElement($apCatalogVbBulkImage)) {
            // set the owning side to null (unless already changed)
            if ($apCatalogVbBulkImage->getUser() === $this) {
                $apCatalogVbBulkImage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApInformationSignature>
     */
    public function getApInformationSignatures(): Collection
    {
        return $this->apInformationSignatures;
    }

    public function addApInformationSignature(ApInformationSignature $apInformationSignature): self
    {
        if (!$this->apInformationSignatures->contains($apInformationSignature)) {
            $this->apInformationSignatures[] = $apInformationSignature;
            $apInformationSignature->setUser($this);
        }

        return $this;
    }

    public function removeApInformationSignature(ApInformationSignature $apInformationSignature): self
    {
        if ($this->apInformationSignatures->removeElement($apInformationSignature)) {
            // set the owning side to null (unless already changed)
            if ($apInformationSignature->getUser() === $this) {
                $apInformationSignature->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApInformationViewed>
     */
    public function getApInformationVieweds(): Collection
    {
        return $this->apInformationVieweds;
    }

    public function addApInformationViewed(ApInformationViewed $apInformationViewed): self
    {
        if (!$this->apInformationVieweds->contains($apInformationViewed)) {
            $this->apInformationVieweds[] = $apInformationViewed;
            $apInformationViewed->setUser($this);
        }

        return $this;
    }

    public function removeApInformationViewed(ApInformationViewed $apInformationViewed): self
    {
        if ($this->apInformationVieweds->removeElement($apInformationViewed)) {
            // set the owning side to null (unless already changed)
            if ($apInformationViewed->getUser() === $this) {
                $apInformationViewed->setUser(null);
            }
        }

        return $this;
    }

}
