<?php

namespace App\Entity;

use App\Repository\ApInformationSignatureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApInformationSignatureRepository::class)
 */
class ApInformationSignature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateTime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $state = 0;

    /**
     * @ORM\ManyToOne(targetEntity=ApInformationFiles::class, inversedBy="apInformationSignatures")
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="apInformationSignatures")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(?\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getFile(): ?ApInformationFiles
    {
        return $this->file;
    }

    public function setFile(?ApInformationFiles $file): self
    {
        $this->file = $file;

        return $this;
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
}
