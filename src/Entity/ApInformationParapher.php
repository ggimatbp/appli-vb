<?php

namespace App\Entity;

use App\Repository\ApInformationParapherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApInformationParapherRepository::class)
 */
class ApInformationParapher
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
     * @ORM\ManyToOne(targetEntity=ApInformationFiles::class, inversedBy="apInformationParaphers")
     *  @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $fileId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ApInformationParaphers")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $User;

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

    public function getFileId(): ?apInformationFiles
    {
        return $this->fileId;
    }

    public function setFileId(?apInformationFiles $fileId): self
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
