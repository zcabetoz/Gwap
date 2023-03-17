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
     * @ORM\ManyToOne(targetEntity="Imagenes")
     * @ORM\JoinColumn(name="imagen_id", referencedColumnName="id")
     */
    private $id_imagen;

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
    public function getIdImagen()
    {
        return $this->id_imagen;
    }

    /**
     * @param mixed $id_imagen
     */
    public function setIdImagen($id_imagen): void
    {
        $this->id_imagen = $id_imagen;
    }
}
