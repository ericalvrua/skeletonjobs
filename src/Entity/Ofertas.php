<?php

namespace App\Entity;

use App\Repository\OfertasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfertasRepository::class)
 */
class Ofertas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $puesto;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\OneToMany(targetEntity=UsuariosEmpresasOfertas::class, mappedBy="ofertas", orphanRemoval=true)
     */
    private $id_oferta;


    /**
     * @ORM\ManyToOne(targetEntity=Empresas::class, inversedBy="oferta")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_empresa;

    /**
     * @ORM\ManyToOne(targetEntity=Categorias::class, inversedBy="id_ofertas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoria;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Provincia;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToMany(targetEntity=Islas::class, mappedBy="id_isla")
     */
    private $islas;

    /**
     * @ORM\OneToMany(targetEntity=Preguntas::class, mappedBy="oferta")
     */
    private $preguntas_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $borrador;

    public function __construct()
    {
        $this->id_oferta = new ArrayCollection();
        $this->islas = new ArrayCollection();
        $this->preguntas_id = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPuesto(): ?string
    {
        return $this->puesto;
    }

    public function setPuesto(string $puesto): self
    {
        $this->puesto = $puesto;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection|UsuariosEmpresasOfertas[]
     */
    public function getIdOferta(): Collection
    {
        return $this->id_oferta;
    }

    public function addIdOfertum(UsuariosEmpresasOfertas $idOfertum): self
    {
        if (!$this->id_oferta->contains($idOfertum)) {
            $this->id_oferta[] = $idOfertum;
            $idOfertum->setOfertas($this);
        }

        return $this;
    }

    public function removeIdOfertum(UsuariosEmpresasOfertas $idOfertum): self
    {
        if ($this->id_oferta->removeElement($idOfertum)) {
            // set the owning side to null (unless already changed)
            if ($idOfertum->getOfertas() === $this) {
                $idOfertum->setOfertas(null);
            }
        }

        return $this;
    }


    public function getIdEmpresa(): ?Empresas
    {
        return $this->id_empresa;
    }

    public function setIdEmpresa(?Empresas $id_empresa): self
    {
        $this->id_empresa = $id_empresa;

        return $this;
    }

    public function getCategoria(): ?Categorias
    {
        return $this->categoria;
    }

    public function setCategoria(?Categorias $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->Provincia;
    }

    public function setProvincia(?string $Provincia): self
    {
        $this->Provincia = $Provincia;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * @return Collection|Islas[]
     */
    public function getIslas(): Collection
    {
        return $this->islas;
    }

    public function addIsla(Islas $isla): self
    {
        if (!$this->islas->contains($isla)) {
            $this->islas[] = $isla;
            $isla->addIdIsla($this);
        }

        return $this;
    }

    public function removeIsla(Islas $isla): self
    {
        if ($this->islas->removeElement($isla)) {
            $isla->removeIdIsla($this);
        }

        return $this;
    }

    /**
     * @return Collection|Preguntas[]
     */
    public function getPreguntasId(): Collection
    {
        return $this->preguntas_id;
    }

    public function addPreguntasId(Preguntas $preguntasId): self
    {
        if (!$this->preguntas_id->contains($preguntasId)) {
            $this->preguntas_id[] = $preguntasId;
            $preguntasId->setOferta($this);
        }

        return $this;
    }

    public function removePreguntasId(Preguntas $preguntasId): self
    {
        if ($this->preguntas_id->removeElement($preguntasId)) {
            // set the owning side to null (unless already changed)
            if ($preguntasId->getOferta() === $this) {
                $preguntasId->setOferta(null);
            }
        }

        return $this;
    }

    public function getBorrador(): ?bool
    {
        return $this->borrador;
    }

    public function setBorrador(bool $borrador): self
    {
        $this->borrador = $borrador;

        return $this;
    }

    
}
