<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CertificatRepository::class)
 */
class Certificat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidat::class, inversedBy="certification")
     * 
     */
    private $condidat;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="certification")
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
