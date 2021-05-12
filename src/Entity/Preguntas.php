<?php

namespace App\Entity;

use App\Repository\PreguntasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PreguntasRepository::class)
 */
class Preguntas
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
    private $Pregunta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Requerido;

    /**
     * @ORM\ManyToOne(targetEntity=Ofertas::class, inversedBy="preguntas_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $oferta;

    /**
     * @ORM\OneToMany(targetEntity=Respuestas::class, mappedBy="pregunta")
     */
    private $Respuesta;

    public function __construct()
    {
        $this->Respuesta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPregunta(): ?string
    {
        return $this->Pregunta;
    }

    public function setPregunta(string $Pregunta): self
    {
        $this->Pregunta = $Pregunta;

        return $this;
    }

    public function getRequerido(): ?bool
    {
        return $this->Requerido;
    }

    public function setRequerido(bool $Requerido): self
    {
        $this->Requerido = $Requerido;

        return $this;
    }

    public function getOferta(): ?Ofertas
    {
        return $this->oferta;
    }

    public function setOferta(?Ofertas $oferta): self
    {
        $this->oferta = $oferta;

        return $this;
    }

    /**
     * @return Collection|Respuestas[]
     */
    public function getRespuesta(): Collection
    {
        return $this->Respuesta;
    }

    public function addRespuestum(Respuestas $respuestum): self
    {
        if (!$this->Respuesta->contains($respuestum)) {
            $this->Respuesta[] = $respuestum;
            $respuestum->setPregunta($this);
        }

        return $this;
    }

    public function removeRespuestum(Respuestas $respuestum): self
    {
        if ($this->Respuesta->removeElement($respuestum)) {
            // set the owning side to null (unless already changed)
            if ($respuestum->getPregunta() === $this) {
                $respuestum->setPregunta(null);
            }
        }

        return $this;
    }
}
