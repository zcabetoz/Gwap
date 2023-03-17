<?php

namespace App\Controller;

use App\Entity\Partidas;
use App\Entity\User;
use App\Repository\PartidasRepository;
use App\Repository\UserRepository;
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
    public function index(): Response
    {
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
            $usuarios = $this->em->getRepository(Partidas::class)->findUsuariosSalas($salaId['sala']);
            $users = '';
            foreach ($usuarios as $usuario) {
                $users .= $usuario['username'] . ', ';
            }
            $data[] = [
                'sala' => $salaId,
                'users' => $users
            ];
        }

        return $this->render('dashboard/index.html.twig', [
            'usuario' => $user->getUserIdentifier(),
            'data' => $data,
            'imagen' => $partidas
        ]);
    }
}
