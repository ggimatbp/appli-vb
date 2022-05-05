<?php

namespace App\Entity;

use App\Repository\ApInformationSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApInformationSectionRepository::class)
 */
class ApInformationSection
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
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity=ApInformationFiles::class, mappedBy="Section")
     */
    private $apInformationFiles;

    /**
     * @ORM\ManyToOne(targetEntity=ApInformationParentSection::class, inversedBy="apInformationSections")
     */
    private $parentSection;

    public function __construct()
    {
        $this->apInformationFiles = new ArrayCollection();
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

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, ApInformationFiles>
     */
    public function getApInformationFiles(): Collection
    {
        return $this->apInformationFiles;
    }

    public function addApInformationFile(ApInformationFiles $apInformationFile): self
    {
        if (!$this->apInformationFiles->contains($apInformationFile)) {
            $this->apInformationFiles[] = $apInformationFile;
            $apInformationFile->setSection($this);
        }

        return $this;
    }

    public function removeApInformationFile(ApInformationFiles $apInformationFile): self
    {
        if ($this->apInformationFiles->removeElement($apInformationFile)) {
            // set the owning side to null (unless already changed)
            if ($apInformationFile->getSection() === $this) {
                $apInformationFile->setSection(null);
            }
        }

        return $this;
    }

    public function getParentSection(): ?ApInformationParentSection
    {
        return $this->parentSection;
    }

    public function setParentSection(?ApInformationParentSection $parentSection): self
    {
        $this->parentSection = $parentSection;

        return $this;
    }
}
