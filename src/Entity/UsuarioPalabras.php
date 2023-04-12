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

    /**
     * @ORM\Column(type="integer")
     */
    private $id_imagen;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero_sala;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_imagen;

    public function __construct($palabras_relacionadas=null, $resultado_palabra = null, $id_imagen = null, $numero_sala = null, $url_imagen = null)
    {
        $this->palabras_relacionadas = $palabras_relacionadas;
        $this->resultado_palabra = $resultado_palabra;
        $this->id_imagen = $id_imagen;
        $this->numero_sala = $numero_sala;
        $this->url_imagen = $url_imagen;
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

    public function getIdImagen(): ?int
    {
        return $this->id_imagen;
    }

    public function setIdImagen(int $id_imagen): self
    {
        $this->id_imagen = $id_imagen;

        return $this;
    }

    public function getNumeroSala(): ?int
    {
        return $this->numero_sala;
    }

    public function setNumeroSala(int $numero_sala): self
    {
        $this->numero_sala = $numero_sala;

        return $this;
    }

    public function getUrlImagen(): ?string
    {
        return $this->url_imagen;
    }

    public function setUrlImagen(string $url_imagen): self
    {
        $this->url_imagen = $url_imagen;

        return $this;
    }
}
