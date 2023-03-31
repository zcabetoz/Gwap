<?php

namespace App\Controller;

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
     * @Route("/estadisticas/partida", name="app_estadisticas_partida")
     */
    public function estadisticasPartidaAction(): Response
    {
        $jugadores = $this->em->getRepository(Partidas::class)->findJugadores();
        $palabrasJugador_1 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[0]['id']);
        $palabrasJugador_2 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[1]['id']);
        $palabrasJugador_3 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[2]['id']);


        return $this->render('estadisticas_partida/index.html.twig', [
            'estadisticas' => $jugadores,
            'jugador_1' => $palabrasJugador_1,
            'jugador_2' => $palabrasJugador_2,
            'jugador_3' => $palabrasJugador_3
        ]);
    }

}
