<?php

namespace App\Entity;

use App\Repository\ApCatalogFilesBpHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApCatalogFilesBpHistoryRepository::class)
 */
class ApCatalogFilesBpHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="apCatalogFilesBpHistories")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=apCatalogFilesBp::class, inversedBy="apCatalogFilesBpHistories")
     */
    private $file;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modelName;

    /**
     * @ORM\Column(type="string", length=510)
     */
    private $docName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFile(): ?apCatalogFilesBp
    {
        return $this->file;
    }

    public function setFile(?apCatalogFilesBp $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getModelName(): ?string
    {
        return $this->modelName;
    }

    public function setModelName(string $modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getDocName(): ?string
    {
        return $this->docName;
    }

    public function setDocName(string $docName): self
    {
        $this->docName = $docName;

        return $this;
    }
}
