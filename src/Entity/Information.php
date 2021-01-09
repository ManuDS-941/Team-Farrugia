<?php

namespace App\Entity;

use App\Repository\InformationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformationRepository::class)
 */
class Information
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Tarif::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Tarif;

    /**
     * @ORM\OneToOne(targetEntity=Site::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Site;

    /**
     * @ORM\OneToOne(targetEntity=Horaire::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Horaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarif(): ?Tarif
    {
        return $this->Tarif;
    }

    public function setTarif(Tarif $Tarif): self
    {
        $this->Tarif = $Tarif;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->Site;
    }

    public function setSite(Site $Site): self
    {
        $this->Site = $Site;

        return $this;
    }

    public function getHoraire(): ?Horaire
    {
        return $this->Horaire;
    }

    public function setHoraire(Horaire $Horaire): self
    {
        $this->Horaire = $Horaire;

        return $this;
    }
}
