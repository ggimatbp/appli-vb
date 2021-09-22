<?php

namespace App\Entity;

use App\Repository\ApEmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApEmployeeRepository::class)
 */
class ApEmployee
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $notification;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $checkin;

    /**
     * @ORM\Column(type="integer")
     */
    private $hour_count;

    /**
     * @ORM\Column(type="integer")
     */
    private $weekly_hour;

    /**
     * @ORM\ManyToOne(targetEntity=ApRole::class, inversedBy="apEmployees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Role;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNotification(): ?bool
    {
        return $this->notification;
    }

    public function setNotification(bool $notification): self
    {
        $this->notification = $notification;

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

    public function getCheckin(): ?bool
    {
        return $this->checkin;
    }

    public function setCheckin(bool $checkin): self
    {
        $this->checkin = $checkin;

        return $this;
    }

    public function getHourCount(): ?int
    {
        return $this->hour_count;
    }

    public function setHourCount(int $hour_count): self
    {
        $this->hour_count = $hour_count;

        return $this;
    }

    public function getWeeklyHour(): ?int
    {
        return $this->weekly_hour;
    }

    public function setWeeklyHour(int $weekly_hour): self
    {
        $this->weekly_hour = $weekly_hour;

        return $this;
    }

    public function getRole(): ?ApRole
    {
        return $this->Role;
    }

    public function setRole(?ApRole $Role): self
    {
        $this->Role = $Role;

        return $this;
    }
}
