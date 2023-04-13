<?php

namespace App\Entity;

use App\Repository\EstadisticasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EstadisticasRepository::class)
 */
class Estadisticas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_jugador;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username_jugador;

    /**
     * @ORM\Column(type="integer")
     */
    private $sala_partida;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre_jugador;

    /**
     * @ORM\Column(type="integer")
     */
    private $partida_finalizada;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdJugador(): ?int
    {
        return $this->id_jugador;
    }

    public function setIdJugador(int $id_jugador): self
    {
        $this->id_jugador = $id_jugador;

        return $this;
    }

    public function getUsernameJugador(): ?string
    {
        return $this->username_jugador;
    }

    public function setUsernameJugador(string $username_jugador): self
    {
        $this->username_jugador = $username_jugador;

        return $this;
    }

    public function getSalaPartida(): ?int
    {
        return $this->sala_partida;
    }

    public function setSalaPartida(int $sala_partida): self
    {
        $this->sala_partida = $sala_partida;

        return $this;
    }

    public function getNombreJugador(): ?string
    {
        return $this->nombre_jugador;
    }

    public function setNombreJugador(string $nombre_jugador): self
    {
        $this->nombre_jugador = $nombre_jugador;

        return $this;
    }

    public function getPartidaFinalizada(): ?int
    {
        return $this->partida_finalizada;
    }

    public function setPartidaFinalizada(int $partida_finalizada): self
    {
        $this->partida_finalizada = $partida_finalizada;

        return $this;
    }
}
