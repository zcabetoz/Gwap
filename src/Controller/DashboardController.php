<?php

namespace App\Controller;

use App\Entity\Imagenes;
use App\Entity\Partidas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
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
     * @Route("/dashboard/", name="app_dashboard")
     */
    public function mostrarPartidasAction(): Response
    {
        $user = $this->getUser();
        if (!isset($user)) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('dashboard/index.html.twig', [
            'usuario' => $user,
            'data' =>[],
        ]);
    }

    /**
     * @Route("/salas-disponible/", name="app_salas_disponibles" , options={"expose"=true})
     */
    public function mostrarSalasAction(): Response
    {
        $numeroJugadores = 0;
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
            $jugadoresSala = $this->em->getRepository(Partidas::class)->findUsuariosSalas($salaId['sala']);
            $numeroJugadores = count($jugadoresSala);
            $users = '';
            foreach ($jugadoresSala as $jugador) {
                $users .= $jugador['username'] . ', ';
            }
            $data[] = [
                'sala' => $salaId,
                'users' => $users
            ];
        }
        $salaJugador = $this->em->getRepository(Partidas::class)->findJugando($this->getUser()->getId());

        return $this->render('dashboard/salas.html.twig', [
            'data' => $data,
            'salaJugador' => $salaJugador,
            'usuario' => $user,
            'numeroJugadores'=>$numeroJugadores
        ]);
    }

    /**
     * @Route("/dashboard/crear-partida", name="app_dashboard_crearpartida")
     */
    public function crearPartidaAction()
    {
        $arrayImagenes = [];
        $i=0;
        $jugando = $this->em->getRepository(Partidas::class)->findJugando($this->getUser()->getId());
        $contadorSalas = $this->em->getRepository(Partidas::class)->findNumeroSalas();
        $contador = empty($contadorSalas) ? 0 : $contadorSalas[0]['contador_salas'];
        if (!$jugando) {
            $cantidadImagenes = $this->em->getRepository(Imagenes::class)->findAll();
            while($i<3){
                $imagenAleatoria = rand(1, count($cantidadImagenes));
                $arrayImagenes[$i] = $imagenAleatoria;
                $i++;
            }
            $imagenId = $this->em->getRepository(Imagenes::class)->find($arrayImagenes[0]);
            $partidas = new Partidas($contador + 1, $contador+1, $arrayImagenes[1], $arrayImagenes[2]);
            $partidas->setUsuarioId($this->getUser());
            $partidas->setImagenId1($imagenId);
            $this->em->persist($partidas);
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
}
