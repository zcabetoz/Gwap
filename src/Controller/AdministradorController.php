<?php

namespace App\Controller;

use App\Entity\Estadisticas;
use App\Entity\Imagenes;
use App\Entity\UsuarioPalabras;
use App\Form\ImagenesType;
use App\Form\PalabraType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        if(!$this->validarRole()){
            return $this->redirectToRoute('app_dashboard');
        }
        $administrador = $this->getUser();
        return $this->render('administrador/index.html.twig', [
            'administrador' => $administrador,

        ]);
    }

    /**
     * @Route("/administrador/listar-imagenes", name="app_listar_imagenes")
     */
    public function listarImagenesAction()
    {
        if(!$this->validarRole()){
            return $this->redirectToRoute('app_dashboard');
        }
        $imagenes = $this->em->getRepository(Imagenes::class)->findAllImages();
        return $this->render('administrador/listar.imagenes.html.twig', [
            'imagenes' => $imagenes
        ]);
    }

    /**
     * @Route("/administrador/mostrar-partidas-jugadas", name="app_mostrar_partidas_jugadas")
     */
    public function mostrarPartidasJugadasAction()
    {
        if(!$this->validarRole()){
            return $this->redirectToRoute('app_dashboard');
        }
        $partidasJugadas = $this->em->getRepository(Estadisticas::class)->findByPartidasJugadas();
        if ($partidasJugadas) {
            for ($i = 0; $i < count($partidasJugadas); $i++) {
                $jugadores = $this->em->getRepository(Estadisticas::class)->findByJugadoresPartidas($partidasJugadas[$i]['sala_partida']);
                $partidasJugadas[$i] = [
                    'sala_partida' => $partidasJugadas[$i]['sala_partida'],
                    'jugador1' => $jugadores[0]['nombre_jugador'],
                    'jugador2' => $jugadores[1]['nombre_jugador'],
                    'jugador3' => $jugadores[2]['nombre_jugador']
                ];
            }
        }
        return $this->render('administrador/mostrar.partidas.html.twig', [
            'partidasJugadas' => $partidasJugadas,
        ]);
    }

    /**
     * @Route("/administrador/mostrar-partidas-jugadas/{partida}/detalle", name="app_mostrar_partidas_jugadas_detalle")
     */
    public function mostrarPartidasJugadasDetalleAction($partida):Response
    {
        if(!$this->validarRole()){
            return $this->redirectToRoute('app_dashboard');
        }
        $palabrasRelacionadas = $this->em->getRepository(UsuarioPalabras::class)->findPalabrasPartidas($partida);

        return $this->render('administrador/mostrar.partidas.detalle.html.twig', [
            'palabrasRelacionadas' => $palabrasRelacionadas
        ]);
    }

    /**
     * @Route ("/administrador/cargar-imagen", name="app_cargar_imagen")
     */
    public function cargarImagenAction(Request $request, SluggerInterface $slugger)
    {
        if(!$this->validarRole()){
            return $this->redirectToRoute('app_dashboard');
        }
        $imagen = new Imagenes();
        $form = $this->createForm(ImagenesType::class, $imagen);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $archivo = $form->get('imagenUrl')->getData();
            if($archivo){
                $originalFileName = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilname = $slugger->slug($originalFileName);
                $newFileName = 'assets/'.$safeFilname.'-'.uniqid().'.'.$archivo->guessExtension();

                try {
                    $archivo->move(
                        $this->getParameter('imagen_directory'),
                        $newFileName
                    );

                }catch (FileException $exception){
                    throw new \Exception('Ocurrio un problema al cargar la imagen');
                }
                $imagen->setImagenUrl($newFileName);
            }
            $this->em->persist($imagen);
            $this->em->flush();
            return $this->redirectToRoute('app_listar_imagenes');
        }
        return $this->render('administrador/cargar.imagen.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *@Route ("/administrador/agregar-palabras/{idImagen}/imagen", name="app_agregar_palabras_imagen")
     */
    public function agregarPalabrasImagenAction($idImagen):Response{
        $form = $this->createForm(PalabraType::class);
        return $this->render('administrador/agregar.palabras.html.twig', [
            'form'=>$form->createView()
        ]);

    }
    public function validarRole(){
        $adminrRole = $this->getUser()->getRoles();
        if ($adminrRole[0] === 'ROLE_USER') {
            return false;
        }else{
            return true;
        }
    }
}
