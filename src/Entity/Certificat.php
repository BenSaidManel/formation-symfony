<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CertificatRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * 
 * @ORM\Entity(repositoryClass=CertificatRepository::class)
 * @ApiResource(
 *   normalizationContext={"groups"={"certif:read"}},
 *     denormalizationContext={"groups"={"certif:write"}}
 * )
 * 
 */
class Certificat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"certif:read","condidat:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidat::class, inversedBy="certification")
     * @Groups({"certif:read","certif:write"})
     * 
     */
    private $condidat;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="certification")
     * @Groups({"certif:read"})
     */
    private $formation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCondidat(): ?Condidat
    {
        return $this->condidat;
    }

    public function setCondidat(?Condidat $condidat): self
    {
        $this->condidat = $condidat;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }
}
