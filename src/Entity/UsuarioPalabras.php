<?php

namespace App\Entity;

use App\Repository\UsuarioPalabrasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsuarioPalabrasRepository::class)
 */
class UsuarioPalabras
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $palabras_relacionadas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultado_palabra;

    public function __construct($palabras_relacionadas=null, $resultado_palabra = null)
    {
        $this->palabras_relacionadas = $palabras_relacionadas;
        $this->resultado_palabra = $resultado_palabra;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUsuario(): ?User
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?User $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    public function getPalabrasRelacionadas(): ?string
    {
        return $this->palabras_relacionadas;
    }

    public function setPalabrasRelacionadas(string $palabras_relacionadas): self
    {
        $this->palabras_relacionadas = $palabras_relacionadas;

        return $this;
    }

    public function getResultadoPalabra(): ?string
    {
        return $this->resultado_palabra;
    }

    public function setResultadoPalabra(string $resultado_palabra): self
    {
        $this->resultado_palabra = $resultado_palabra;

        return $this;
    }
}