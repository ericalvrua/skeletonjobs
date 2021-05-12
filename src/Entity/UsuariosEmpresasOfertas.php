<?php

namespace App\Entity;

use App\Repository\UsuariosEmpresasOfertasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsuariosEmpresasOfertasRepository::class)
 */
class UsuariosEmpresasOfertas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Usuarios::class, inversedBy="id_usuario")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuarios;

    /**
     * @ORM\ManyToOne(targetEntity=Ofertas::class, inversedBy="ofertas_id")
     * @ORM\JoinColumn(nullable=false)
     */

    private $ofertas;

    /**
     * @ORM\ManyToOne(targetEntity=Empresas::class, inversedBy="triple")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_empresa;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $descartado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarios(): ?Usuarios
    {
        return $this->usuarios;
    }

    public function setUsuarios(?Usuarios $usuarios): self
    {
        $this->usuarios = $usuarios;

        return $this;
    }


    public function getOfertas(): ?Ofertas
    {
        return $this->ofertas;
    }

    public function setOfertas(?Ofertas $ofertas): self
    {
        $this->ofertas = $ofertas;

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

    public function getDescartado(): ?bool
    {
        return $this->descartado;
    }

    public function setDescartado(?bool $descartado): self
    {
        $this->descartado = $descartado;

        return $this;
    }
}
