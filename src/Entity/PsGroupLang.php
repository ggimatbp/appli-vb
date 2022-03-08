<?php

namespace App\Entity;

use App\Repository\PsGroupLangRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PsGroupLangRepository::class)
 */
class PsGroupLang
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_lang;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_group;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLang(): ?int
    {
        return $this->id_lang;
    }

    public function setIdLang(int $id_lang): self
    {
        $this->id_lang = $id_lang;

        return $this;
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

    public function getIdGroup(): ?int
    {
        return $this->id_group;
    }

    public function setIdGroup(?int $id_group): self
    {
        $this->id_group = $id_group;

        return $this;
    }
}
