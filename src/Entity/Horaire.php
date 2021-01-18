<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HoraireRepository::class)
 */
class Horaire
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jour1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jour2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jour3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entraineur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getJour1(): ?string
    {
        return $this->jour1;
    }

    public function setJour1(string $jour1): self
    {
        $this->jour1 = $jour1;

        return $this;
    }

    public function getJour2(): ?string
    {
        return $this->jour2;
    }

    public function setJour2(string $jour2): self
    {
        $this->jour2 = $jour2;

        return $this;
    }

    public function getJour3(): ?string
    {
        return $this->jour3;
    }

    public function setJour3(string $jour3): self
    {
        $this->jour3 = $jour3;

        return $this;
    }

    public function getEntraineur(): ?string
    {
        return $this->entraineur;
    }

    public function setEntraineur(?string $entraineur): self
    {
        $this->entraineur = $entraineur;

        return $this;
    }
}
