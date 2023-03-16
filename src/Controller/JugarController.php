<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JugarController extends AbstractController
{
    /**
     * @Route("/jugar", name="app_jugar")
     */
    public function index(): Response
    {
        return $this->render('jugar/index.html.twig', [
            'controller_name' => 'JugarController',
        ]);
    }
}
