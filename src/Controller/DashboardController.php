<?php

namespace App\Controller;

use App\Entity\Estadisticas;
use App\Entity\Imagenes;
use App\Entity\Partidas;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
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
     * @Route("/dashboard/", name="app_dashboard")
     */
    public function mostrarPartidasAction(): Response
    {
        $user = $this->getUser();
        if (!isset($user)) {
            return $this->redirectToRoute('app_login');
        }
        $rol = $user->getRoles();
        return $this->render('dashboard/index.html.twig', [
            'usuario' => $user,
            'data' =>[],
            'estadoPartida'=>[],
            'rol'=>$rol[0]
        ]);
    }

    /**
     * @Route("/salas-disponible/", name="app_salas_disponibles" , options={"expose"=true})
     */
    public function mostrarSalasActionAction(): Response
    {
        $estadoPartida = [];
        $i = 0;
        $user = $this->getUser();
        $partidas = $this->em->getRepository(Partidas::class)->findBySala();
        $salas = [];
        foreach ($partidas as $numeroSala) {
            if (!in_array($numeroSala, $salas)) {
                $salas[] = $numeroSala;
            }
        }
        $data = [];

        foreach ($salas as $salaId) {
            $estadoPartida[$i] = $this->em->getRepository(Partidas::class)->findByEstadoPartida($salas[$i]['sala']);
            $jugadoresSala = $this->em->getRepository(Partidas::class)->findUsuariosSalas($salaId['sala']);
            $users = '';
            foreach ($jugadoresSala as $jugador) {
                $users .= $jugador['username'] . ', ';
            }
            $data[] = [
                'sala' => $salaId,
                'users' => $users,
                'estadoSala'=>$estadoPartida[$i]
            ];
            $i++;
        }
        $numeroJugadores = empty($jugadoresSala) ? 0 : count($jugadoresSala);
        $salaJugador = $this->em->getRepository(Partidas::class)->findJugando($this->getUser()->getId());
        return $this->render('dashboard/salas.html.twig', [
            'data' => $data,
            'salaJugador' => $salaJugador,
            'usuario' => $user,
            'numeroJugadores'=>$numeroJugadores,
            'estadoPartida'=>$estadoPartida
        ]);
    }

    /**
     * @Route("/dashboard/crear-partida", name="app_dashboard_crearpartida")
     */
    public function crearPartidaAction()
    {
        $ultimaPartida = $this->em->getRepository(Estadisticas::class)->findUltimaPartida();
        $contador = empty($ultimaPartida) ? 0 : $ultimaPartida[0]['sala_partida'];
        $arrayImagenes = [];
        $jugando = $this->em->getRepository(Partidas::class)->findJugando($this->getUser()->getId());
        if (!$jugando) {
            $cantidadImagenes = $this->em->getRepository(Imagenes::class)->findAll();
            while(count($arrayImagenes)<3){
                $imagenAleatoria = rand(1, count($cantidadImagenes));
                if(!in_array($imagenAleatoria, $arrayImagenes) ){
                    $arrayImagenes[] = $imagenAleatoria;
                }
            }
            $imagenId = $this->em->getRepository(Imagenes::class)->find($arrayImagenes[0]);
            $partidas = new Partidas($contador + 1, $contador+1, $arrayImagenes[1], $arrayImagenes[2], 1, 1);
            $estadisiticas = new Estadisticas();
            $estadisiticas->setUsernameJugador($this->getUser()->getUserIdentifier());
            $estadisiticas->setIdJugador($this->getUser()->getId());
            $estadisiticas->setNombreJugador($this->getUser()->getNombre());
            $estadisiticas->setSalaPartida($contador+1);
            $estadisiticas->setPartidaFinalizada(0);
            $partidas->setUsuarioId($this->getUser());
            $partidas->setImagenId1($imagenId);
            $this->em->persist($partidas);
            $this->em->persist($estadisiticas);
            $this->em->flush();
        } else {
            $this->addFlash(
                'notice',
                Partidas::JUGANDO
            );
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->redirectToRoute('app_jugar', array('sala' => $contador + 1));
    }

    /**
     * @Route("/dashboard/stadisticas-globales", name="app_dashboard_estadisticas_globales")
     */
    public function estadisticasGlobalesAction(){

        $usuarios = $this->em->getRepository(User::class)->findByPuntajeGlobal();

        return $this->render('dashboard/estadisiticas.globales.html.twig',[
            'usuarios'=>$usuarios
        ]);
    }
}
