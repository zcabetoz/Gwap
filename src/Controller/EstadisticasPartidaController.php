<?php

namespace App\Controller;

use App\Entity\Estadisticas;
use App\Entity\Palabra;
use App\Entity\Partidas;
use App\Entity\UsuarioPalabras;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstadisticasPartidaController extends AbstractController
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
     * @Route("/estadisticas/partida/{idSala}", name="app_estadisticas_partida")
     */
    public function estadisticasPartidaAction($idSala): Response
    {


        $idUsuario = $this->getUser()->getId();
        $partidaJugador = $this->em->getRepository(Partidas::class)->findByIdSalaJugador($idUsuario);
        $eliminarPartidaJugador = $this->em->getRepository(Partidas::class)->find($partidaJugador[0]['id']);
        $this->em->remove($eliminarPartidaJugador);
        $this->em->flush();
        $jugadores = $this->em->getRepository(Estadisticas::class)->findJugadores($idSala);
        $palabrasJugador_1 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[0]['id_jugador']);
        $palabrasJugador_2 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[1]['id_jugador']);
        $palabrasJugador_3 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[2]['id_jugador']);


        return $this->render('estadisticas_partida/index.html.twig', [
            'jugadores' => $jugadores,
            'jugador_1' => $palabrasJugador_1,
            'jugador_2' => $palabrasJugador_2,
            'jugador_3' => $palabrasJugador_3
        ]);
    }

}
