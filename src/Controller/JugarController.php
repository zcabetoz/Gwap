<?php

namespace App\Controller;

use App\Entity\Imagenes;
use App\Entity\Partidas;
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
    public function index($sala): Response
    {
        $idImagen = $this->em->getRepository(Partidas::class)->findImagen($sala);
        $urlImagen = $this->em->getRepository(Imagenes::class)->findUrlImagen($idImagen);
        return $this->render('jugar/index.html.twig', [
            'controller_name' => 'JugarController',
            'sala'=>$sala,
            'url'=>$urlImagen
        ]);
    }
}
