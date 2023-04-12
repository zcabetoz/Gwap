<?php

namespace App\Controller;

use App\Entity\Estadisticas;
use App\Entity\Imagenes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministradorController extends AbstractController
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
     * @Route("/administrador", name="app_administrador")
     */
    public function indexAction(): Response
    {
        $administrador = $this->getUser();
        $adminrRole = $this->getUser()->getRoles();
        if($adminrRole[0] === 'ROLE_USER'){
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('administrador/index.html.twig', [
            'administrador' => $administrador,

        ]);
    }

    /**
     *@Route("/administrador/listar-imagenes", name="app_listar_imagenes")
     */
    public function listarImagenesAction(){
        $adminrRole = $this->getUser()->getRoles();
        if($adminrRole[0] === 'ROLE_USER'){
            return $this->redirectToRoute('app_dashboard');
        }
        $imagenes = $this->em->getRepository(Imagenes::class)->findAll();
        return $this->render('administrador/listar.imagenes.html.twig',[
            'imagenes'=>$imagenes
        ]);
    }

    /**
     *@Route("/administrador/mostrar-partidas-jugadas", name="app_mostrar_partidas_jugadas")
     */
    public function mostrarPartidasJugadasAction(){
        $adminrRole = $this->getUser()->getRoles();
        if($adminrRole[0] === 'ROLE_USER'){
            return $this->redirectToRoute('app_dashboard');
        }
        $partidasJugadas = $this->em->getRepository(Estadisticas::class)->findByPartidasJugadas();
        dump($partidasJugadas);
        if($partidasJugadas){
            for($i=0; $i<count($partidasJugadas);$i++){
                $jugadores = $this->em->getRepository(Estadisticas::class)->findByJugadoresPartidas($partidasJugadas[$i]['sala_partida']);
                $partidasJugadas[$i] = [
                    'sala_partida'=>$partidasJugadas[$i]['sala_partida'],
                    'jugador1' => $jugadores[0]['nombre_jugador'],
                    'jugador2' => $jugadores[1]['nombre_jugador'],
                    'jugador3'=>$jugadores[2]['nombre_jugador']
                ];
            }
        }
        return $this->render('administrador/mostrar.partidas.html.twig',[
            'partidasJugadas'=>$partidasJugadas,
        ]);
    }
}
