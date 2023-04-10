<?php

namespace App\Controller;

use App\Entity\Imagenes;
use Doctrine\ORM\EntityManager;
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
    public function index(): Response
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
    public function listarImagenes(){
        $adminrRole = $this->getUser()->getRoles();
        if($adminrRole[0] === 'ROLE_USER'){
            return $this->redirectToRoute('app_dashboard');
        }
        $imagenes = $this->em->getRepository(Imagenes::class)->findAll();
        return $this->render('administrador/listar.imagenes.html.twig',[
            'imagenes'=>$imagenes
        ]);
    }
}
