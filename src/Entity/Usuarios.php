<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsuariosRepository::class)
 */
class Usuarios
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
     * @ORM\Column(type="string", length=255)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dni;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $correo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_nacimiento;

    /**
     * @ORM\Column(type="integer")
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(type="integer", nullable=true)
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=UsuariosEmpresasOfertas::class, mappedBy="usuarios", orphanRemoval=true)
     */
    private $id_usuario;

    /**
     * @ORM\OneToMany(targetEntity=Respuestas::class, mappedBy="usuario")
     */
    private $respuestas;

    public function __construct()
    {
        $this->id_usuario = new ArrayCollection();
        $this->respuestas = new ArrayCollection();
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

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

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

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

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

    public function getCodigoPostal(): ?int
    {
        return $this->codigo_postal;
    }

    public function setCodigoPostal(?int $codigo_postal): self
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

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

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

    public function getUsuarios(): ?self
    {
        return $this->usuarios;
    }

    public function setUsuarios(?self $usuarios): self
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * @return Collection|UsuariosEmpresasOfertas[]
     */
    public function getIdUsuario(): Collection
    {
        return $this->id_usuario;
    }

    public function addIdUsuario(UsuariosEmpresasOfertas $idUsuario): self
    {
        if (!$this->id_usuario->contains($idUsuario)) {
            $this->id_usuario[] = $idUsuario;
            $idUsuario->setUsuarios($this);
        }

        return $this;
    }

    public function removeIdUsuario(UsuariosEmpresasOfertas $idUsuario): self
    {
        if ($this->id_usuario->removeElement($idUsuario)) {
            // set the owning side to null (unless already changed)
            if ($idUsuario->getUsuarios() === $this) {
                $idUsuario->setUsuarios(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Respuestas[]
     */
    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }

    public function addRespuesta(Respuestas $respuesta): self
    {
        if (!$this->respuestas->contains($respuesta)) {
            $this->respuestas[] = $respuesta;
            $respuesta->setUsuario($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuestas $respuesta): self
    {
        if ($this->respuestas->removeElement($respuesta)) {
            // set the owning side to null (unless already changed)
            if ($respuesta->getUsuario() === $this) {
                $respuesta->setUsuario(null);
            }
        }

        return $this;
    }

}