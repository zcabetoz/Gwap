<?php

namespace App\Controller;

use App\Entity\Imagenes;
use App\Entity\Partidas;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JugarController extends AbstractController
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/jugar/{sala}", name="app_jugar")
     */
    public function index(Request $request, $sala = null): Response
    {
        $contadorSalas = $this->em->getRepository(Partidas::class)->findNumeroSalas();
        $partida = new Partidas($sala, $contadorSalas[0]['contador_salas']);
        $idImagen = $this->em->getRepository(Partidas::class)->findImagen($sala);
        $get = $request->query->all();

        if(isset($get['idJugador'])){
            $jugando = $this->em->getRepository(Partidas::class)->findJugando($get['idJugador']);
            if(!$jugando){
                $jugador = $this->em->getRepository(User::class)->find($get['idJugador']);
                $imagen = $this->em->getRepository(Imagenes::class)->find($idImagen[0]['id']);
                $partida->setUsuarioId($jugador);
                $partida->setImagenesId($imagen);
                $this->em->persist($partida);
                $this->em->flush();
            }
        }
        $urlImagen = $this->em->getRepository(Imagenes::class)->findUrlImagen($idImagen);
        return $this->render('jugar/index.html.twig', [
            'sala' => $sala,
            'url' => $urlImagen
        ]);
    }
}
