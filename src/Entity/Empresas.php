<?php

namespace App\Entity;

use App\Repository\EmpresasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpresasRepository::class)
 */
class Empresas
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
    private $cif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $correo;

    /**
     * @ORM\Column(type="integer")
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo_postal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pais;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $provincia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=Ofertas::class, mappedBy="id_empresa")
     */
    private $oferta;

    /**
     * @ORM\OneToMany(targetEntity=UsuariosEmpresasOfertas::class, mappedBy="id_empresa")
     */
    private $triple;

    public function __construct()
    {
        $this->oferta = new ArrayCollection();
        $this->triple = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCif(): ?string
    {
        return $this->cif;
    }

    public function setCif(string $cif): self
    {
        $this->cif = $cif;

        return $this;
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

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): self
    {
        $this->pass = $pass;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigo_postal;
    }

    public function setCodigoPostal(?string $codigo_postal): self
    {
        $this->codigo_postal = $codigo_postal;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(?string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(?string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(?string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|Ofertas[]
     */
    public function getOferta(): Collection
    {
        return $this->oferta;
    }

    public function addOfertum(Ofertas $ofertum): self
    {
        if (!$this->oferta->contains($ofertum)) {
            $this->oferta[] = $ofertum;
            $ofertum->setIdEmpresa($this);
        }

        return $this;
    }

    public function removeOfertum(Ofertas $ofertum): self
    {
        if ($this->oferta->removeElement($ofertum)) {
            // set the owning side to null (unless already changed)
            if ($ofertum->getIdEmpresa() === $this) {
                $ofertum->setIdEmpresa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UsuariosEmpresasOfertas[]
     */
    public function getTriple(): Collection
    {
        return $this->triple;
    }

    public function addTriple(UsuariosEmpresasOfertas $triple): self
    {
        if (!$this->triple->contains($triple)) {
            $this->triple[] = $triple;
            $triple->setIdEmpresa($this);
        }

        return $this;
    }

    public function removeTriple(UsuariosEmpresasOfertas $triple): self
    {
        if ($this->triple->removeElement($triple)) {
            // set the owning side to null (unless already changed)
            if ($triple->getIdEmpresa() === $this) {
                $triple->setIdEmpresa(null);
            }
        }

        return $this;
    }
}
