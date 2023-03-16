<?php

namespace App\Entity;

use App\Repository\PalabraRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PalabraRepository::class)
 */
class Palabra
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
    private $palabra;

    /**
     * @ORM\ManyToOne(targetEntity="Imagen")
     * @ORM\JoinColumn(name="imagen_id", referencedColumnName="id")
     */
    private $imagen;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPalabra()
    {
        return $this->palabra;
    }

    /**
     * @param mixed $palabra
     */
    public function setPalabra($palabra): void
    {
        $this->palabra = $palabra;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen): void
    {
        $this->imagen = $imagen;
    }
}
