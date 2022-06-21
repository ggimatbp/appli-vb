<?php

namespace App\Entity;

use App\Repository\ApInformationParentSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApInformationParentSectionRepository::class)
 */
class ApInformationParentSection
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
     * @ORM\OneToMany(targetEntity=ApInformationSection::class, mappedBy="parentSection")
     */
    private $apInformationSections;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    public function __construct()
    {
        $this->apInformationSections = new ArrayCollection();
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
     * @return Collection<int, ApInformationSection>
     */
    public function getApInformationSections(): Collection
    {
        return $this->apInformationSections;
    }

    public function addApInformationSection(ApInformationSection $apInformationSection): self
    {
        if (!$this->apInformationSections->contains($apInformationSection)) {
            $this->apInformationSections[] = $apInformationSection;
            $apInformationSection->setParentSection($this);
        }

        return $this;
    }

    public function removeApInformationSection(ApInformationSection $apInformationSection): self
    {
        if ($this->apInformationSections->removeElement($apInformationSection)) {
            // set the owning side to null (unless already changed)
            if ($apInformationSection->getParentSection() === $this) {
                $apInformationSection->setParentSection(null);
            }
        }

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }
}
