<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministradorController extends AbstractController
{
    /**
     * @Route("/administrador", name="app_administrador")
     */
    public function index(): Response
    {
        $adminrRole = $this->getUser()->getRoles();
        if($adminrRole[0] === 'ROLE_USER'){
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('administrador/index.html.twig', [
            'controller_name' => 'AdministradorController',
        ]);
    }
}
