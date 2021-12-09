<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="formation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Condidat::class, mappedBy="formation")
     */
    private $condidats;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=Certificat::class, mappedBy="formation")
     */
    private $certification;

    public function __construct()
    {
        $this->condidats = new ArrayCollection();
        $this->certification = new ArrayCollection();
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

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection|Condidat[]
     */
    public function getCondidats(): Collection
    {
        return $this->condidats;
    }

    public function addCondidat(Condidat $condidat): self
    {
        if (!$this->condidats->contains($condidat)) {
            $this->condidats[] = $condidat;
            $condidat->addFormation($this);
        }

        return $this;
    }

    public function removeCondidat(Condidat $condidat): self
    {
        if ($this->condidats->removeElement($condidat)) {
            $condidat->removeFormation($this);
        }

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Certificat[]
     */
    public function getCertification(): Collection
    {
        return $this->certification;
    }

    public function addCertification(Certificat $certification): self
    {
        if (!$this->certification->contains($certification)) {
            $this->certification[] = $certification;
            $certification->setFormation($this);
        }

        return $this;
    }

    public function removeCertification(Certificat $certification): self
    {
        if ($this->certification->removeElement($certification)) {
            // set the owning side to null (unless already changed)
            if ($certification->getFormation() === $this) {
                $certification->setFormation(null);
            }
        }

        return $this;
    }
}
