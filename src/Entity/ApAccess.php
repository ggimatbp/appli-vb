<?php

namespace App\Entity;

use App\Repository\ApAccessRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApAccessRepository::class)
 */
class ApAccess
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $_view;

    /**
     * @ORM\Column(type="boolean")
     */
    private $_add;

    /**
     * @ORM\Column(type="boolean")
     */
    private $_edit;

    /**
     * @ORM\ManyToOne(targetEntity=ApTab::class, inversedBy="apAccesses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tab;

    /**
     * @ORM\ManyToOne(targetEntity=ApRole::class, inversedBy="apAccesses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\Column(type="boolean")
     */
    private $_delete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getView(): ?bool
    {
        return $this->_view;
    }

    public function setView(bool $_view): self
    {
        $this->_view = $_view;

        return $this;
    }

    public function getAdd(): ?bool
    {
        return $this->_add;
    }

    public function setAdd(bool $_add): self
    {
        $this->_add = $_add;

        return $this;
    }

    public function getEdit(): ?bool
    {
        return $this->_edit;
    }

    public function setEdit(bool $_edit): self
    {
        $this->_edit = $_edit;

        return $this;
    }

    public function getTab(): ?ApTab
    {
        return $this->tab;
    }

    public function setTab(?ApTab $tab): self
    {
        $this->tab = $tab;

        return $this;
    }

    public function getRole(): ?ApRole
    {
        return $this->role;
    }

    public function setRole(?ApRole $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDelete(): ?bool
    {
        return $this->_delete;
    }

    public function setDelete(bool $_delete): self
    {
        $this->_delete = $_delete;

        return $this;
    }
}
