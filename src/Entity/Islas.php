<?php

namespace App\Entity;

use App\Repository\IslasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IslasRepository::class)
 */
class Islas
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
    private $Nombre;

    /**
     * @ORM\ManyToMany(targetEntity=Ofertas::class, inversedBy="islas")
     */
    private $id_isla;

    public function __construct()
    {
        $this->id_isla = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    /**
     * @return Collection|Ofertas[]
     */
    public function getIdIsla(): Collection
    {
        return $this->id_isla;
    }

    public function addIdIsla(Ofertas $idIsla): self
    {
        if (!$this->id_isla->contains($idIsla)) {
            $this->id_isla[] = $idIsla;
        }

        return $this;
    }

    public function removeIdIsla(Ofertas $idIsla): self
    {
        $this->id_isla->removeElement($idIsla);

        return $this;
    }
}
