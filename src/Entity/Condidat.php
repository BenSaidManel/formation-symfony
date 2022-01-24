<?php

namespace App\Entity;

use App\Entity\Formation;
use App\Entity\Certificat;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CondidatRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *
 * @ORM\Entity(repositoryClass=CondidatRepository::class)
 * @ApiResource(
 *    normalizationContext={"groups"={"condidat:read"}},
 *     denormalizationContext={"groups"={"condidat:write"}}
 *     )
 */
class Condidat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"condidat:read","certif:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"condidat:read","condidat:write","certif:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"condidat:read","condidat:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"condidat:read","condidat:write"})
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, inversedBy="condidats")
     * @Groups({"condidat:read","condidat:write"})
     */
    private $formation;

    /**
     * @ORM\OneToMany(targetEntity=Certificat::class, mappedBy="condidat")
     * @Groups({"condidat:read"})
     */
    private $certification;

    public function __construct()
    {
        $this->formation = new ArrayCollection();
        $this->certification = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    /**
     * @return Collection|Formation[]
     */
    public function getFormation(): Collection
    {
        return $this->formation;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formation->contains($formation)) {
            $this->formation[] = $formation;
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        $this->formation->removeElement($formation);

        return $this;
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
            $certification->setCondidat($this);
        }

        return $this;
    }

    public function removeCertification(Certificat $certification): self
    {
        if ($this->certification->removeElement($certification)) {
            // set the owning side to null (unless already changed)
            if ($certification->getCondidat() === $this) {
                $certification->setCondidat(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
