<?php

namespace App\Controller;

use App\Entity\Estadisticas;
use App\Entity\Partidas;
use App\Entity\UsuarioPalabras;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstadisticasPartidaController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
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
        $usuario = $this->getUser();
        $pc1[] = '';
        $pc2[] = '';
        $pc3[] = '';
        $idUsuario = $this->getUser()->getId();
        $partidaJugador = $this->em->getRepository(Partidas::class)->findByIdSalaJugador($idUsuario);

        $jugadores = $this->em->getRepository(Estadisticas::class)->findJugadores($idSala);

        $palabrasCorrectasJ1 = $this->em->getRepository(UsuarioPalabras::class)->palabrasCorrectas($jugadores[0]['id_jugador'], $idSala);
        for ($i = 0; $i < count($palabrasCorrectasJ1); $i++) {
            $pc1[$i] = $palabrasCorrectasJ1[$i]['palabras_relacionadas'];
        }
        $palabrasCorrectasJ2 = $this->em->getRepository(UsuarioPalabras::class)->palabrasCorrectas($jugadores[1]['id_jugador'], $idSala);
        for ($i = 0; $i < count($palabrasCorrectasJ2); $i++) {
            $pc2[$i] = $palabrasCorrectasJ2[$i]['palabras_relacionadas'];
        }
        $palabrasCorrectasJ3 = $this->em->getRepository(UsuarioPalabras::class)->palabrasCorrectas($jugadores[2]['id_jugador'], $idSala);
        for ($i = 0; $i < count($palabrasCorrectasJ3); $i++) {
            $pc3[$i] = $palabrasCorrectasJ3[$i]['palabras_relacionadas'];
        }

       $puntaje200 = array_intersect($pc1, $pc2, $pc3);
        if(!empty($puntaje200)){
            if($puntaje200[array_key_first($puntaje200)] == "") {
                $p200 = 0;
            }else{
                    $p200 = count($puntaje200);
            }
        }else{
            $p200 =0;
        }

        $palabrasJugador_1 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[0]['id_jugador'], $idSala);
        $puntajeJugador_1 = (count($palabrasCorrectasJ1)*100) + ($p200*100);
        $palabrasJugador_2 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[1]['id_jugador'], $idSala);
        $puntajeJugador_2 = (count($palabrasCorrectasJ2)*100) + ($p200*100);
        $palabrasJugador_3 = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasJugador($jugadores[2]['id_jugador'], $idSala);
        $puntajeJugador_3 = (count($palabrasCorrectasJ3)*100) + ($p200*100);

        dump($palabrasJugador_1);
        try {
            $eliminarPartidaJugador = $this->em->getRepository(Partidas::class)->find($partidaJugador[0]['id']);
            $misPalabrasCorrectas = $this->em->getRepository(UsuarioPalabras::class)->palabrasCorrectas($idUsuario, $idSala);
            $puntajePartida = (count($misPalabrasCorrectas)*100) + ($p200*100);
            $usuario->setPuntajePartida($puntajePartida);
            $puntajeGlobal = $usuario->getPuntajeGlobal();
            $puntajeGlobal +=$puntajePartida;
            $usuario->setPuntajeGlobal($puntajeGlobal);
            $this->em->remove($eliminarPartidaJugador);
            $this->em->flush();
        } catch (\Exception $e) {

        }
        return $this->render('estadisticas_partida/index.html.twig', [
            'jugadores' => $jugadores,
            'jugador_1' => $palabrasJugador_1,
            'jugador_2' => $palabrasJugador_2,
            'jugador_3' => $palabrasJugador_3,
            'puntajeJugador_1' => $puntajeJugador_1,
            'puntajeJugador_2' => $puntajeJugador_2,
            'puntajeJugador_3' => $puntajeJugador_3,
            'coincidencias'=>$puntaje200

        ]);
    }
}
