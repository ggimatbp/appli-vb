<?php

namespace App\Entity;

use App\Repository\ApInformationViewedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApInformationViewedRepository::class)
 */
class ApInformationViewed
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
    private $datetime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $state = 0;

    /**
     * @ORM\ManyToOne(targetEntity=apInformationFiles::class, inversedBy="apInformationVieweds")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="apInformationVieweds")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

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

    public function getFile(): ?apInformationFiles
    {
        return $this->file;
    }

    public function setFile(?apInformationFiles $file): self
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
