<?php

namespace App\Entity;

use App\Repository\PartidasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartidasRepository::class)
 */
class Partidas
{
    const JUGANDO = "Ya te encuentras en una partida!";
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
    private $usuarioId;

    /**
     * @ORM\ManyToOne(targetEntity=Imagenes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $imagenesId;

    /**
     * @ORM\Column(type="integer")
     */
    private $sala;

    /**
     * @ORM\Column(type="integer")
     */
    private $contador_salas;

    public function __construct($sala = null, $contador_salas = null)
    {
        $this->sala = $sala;
        $this->contador_salas = $contador_salas;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioId(): ?User
    {
        return $this->usuarioId;
    }

    public function setUsuarioId(?User $usuarioId): self
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    public function getImagenesId(): ?Imagenes
    {
        return $this->imagenesId;
    }

    public function setImagenesId(?Imagenes $imagenesId): self
    {
        $this->imagenesId = $imagenesId;

        return $this;
    }

    public function getSala(): ?int
    {
        return $this->sala;
    }

    public function setSala(int $sala): self
    {
        $this->sala = $sala;

        return $this;
    }

    public function getContadorSalas(): ?int
    {
        return $this->contador_salas;
    }

    public function setContadorSalas(int $contador_salas): self
    {
        $this->contador_salas = $contador_salas;

        return $this;
    }
}
