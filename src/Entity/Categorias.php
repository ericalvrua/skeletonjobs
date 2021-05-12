<?php

namespace App\Entity;

use App\Repository\CategoriasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriasRepository::class)
 */
class Categorias
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
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity=Ofertas::class, mappedBy="categoria")
     */
    private $id_ofertas;

    public function __construct()
    {
        $this->id_ofertas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection|Ofertas[]
     */
    public function getIdOfertas(): Collection
    {
        return $this->id_ofertas;
    }

    public function addIdOferta(Ofertas $idOferta): self
    {
        if (!$this->id_ofertas->contains($idOferta)) {
            $this->id_ofertas[] = $idOferta;
            $idOferta->setCategoria($this);
        }

        return $this;
    }

    public function removeIdOferta(Ofertas $idOferta): self
    {
        if ($this->id_ofertas->removeElement($idOferta)) {
            // set the owning side to null (unless already changed)
            if ($idOferta->getCategoria() === $this) {
                $idOferta->setCategoria(null);
            }
        }

        return $this;
    }
}
