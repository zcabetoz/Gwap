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
    private $imagenId_1;

    /**
     * @ORM\Column(type="integer")
     */
    private $sala;

    /**
     * @ORM\Column(type="integer")
     */
    private $contador_salas;

    /**
     * @ORM\Column(type="integer")
     */
    private $imagenId_2;

    /**
     * @ORM\Column(type="integer")
     */
    private $imagenId_3;

    /**
     * @ORM\Column(type="integer")
     */
    private $estado_partida;

    /**
     * @ORM\Column(type="integer")
     */
    private $contador_jugadores;

    public function __construct($sala = null, $contador_salas = null, $imagenId_2 = null, $imagenId_3 = null, $estado_partida = null, $contador_jugadores = null)
    {
        $this->sala = $sala;
        $this->contador_salas = $contador_salas;
        $this->imagenId_2 = $imagenId_2;
        $this->imagenId_3 = $imagenId_3;
        $this->estado_partida = $estado_partida;
        $this->contador_jugadores = $contador_jugadores;
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

    public function getImagenId1(): ?Imagenes
    {
        return $this->imagenId_1;
    }

    public function setImagenId1(?Imagenes $imagenId_1): self
    {
        $this->imagenId_1 = $imagenId_1;

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

    public function getImagenId2(): ?int
    {
        return $this->imagenId_2;
    }

    public function setImagenId2(int $imagenId_2): self
    {
        $this->imagenId_2 = $imagenId_2;

        return $this;
    }

    public function getImagenId3(): ?int
    {
        return $this->imagenId_3;
    }

    public function setImagenId3(int $imagenId_3): self
    {
        $this->imagenId_3 = $imagenId_3;

        return $this;
    }

    public function getEstadoPartida(): ?int
    {
        return $this->estado_partida;
    }

    public function setEstadoPartida(int $estado_partida): self
    {
        $this->estado_partida = $estado_partida;

        return $this;
    }

    public function getContadorJugadores(): ?int
    {
        return $this->contador_jugadores;
    }

    public function setContadorJugadores(int $contador_jugadores): self
    {
        $this->contador_jugadores = $contador_jugadores;

        return $this;
    }
}
