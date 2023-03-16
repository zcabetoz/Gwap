<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReglasController extends AbstractController
{
    /**
     * @Route("/reglas", name="app_reglas")
     */
    public function index(): Response
    {
        return $this->render('reglas/index.html.twig', [

        ]);
    }
}
