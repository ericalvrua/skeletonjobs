<?php

namespace App\Entity;

use App\Repository\RespuestasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RespuestasRepository::class)
 */
class Respuestas
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
    private $Respuesta;

    /**
     * @ORM\ManyToOne(targetEntity=Usuarios::class, inversedBy="respuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity=Preguntas::class, inversedBy="Respuesta")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pregunta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRespuesta(): ?string
    {
        return $this->Respuesta;
    }

    public function setRespuesta(string $Respuesta): self
    {
        $this->Respuesta = $Respuesta;

        return $this;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuarios $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getPregunta(): ?Preguntas
    {
        return $this->pregunta;
    }

    public function setPregunta(?Preguntas $pregunta): self
    {
        $this->pregunta = $pregunta;

        return $this;
    }
}
