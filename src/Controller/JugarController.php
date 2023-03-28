<?php

namespace App\Controller;

use App\Entity\Imagenes;
use App\Entity\Palabra;
use App\Entity\Partidas;
use App\Entity\User;
use App\Entity\UsuarioPalabras;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index(Request $request, $sala = null): Response
    {
        $contadorSalas = $this->em->getRepository(Partidas::class)->findNumeroSalas();
        $partida = new Partidas($sala, $contadorSalas[0]['contador_salas']);
        $idImagen = $this->em->getRepository(Partidas::class)->findImagen($sala);
        $get = $request->query->all();

        if (isset($get['idJugador'])) {
            $jugando = $this->em->getRepository(Partidas::class)->findJugando($get['idJugador']);
            if (!$jugando) {
                $jugador = $this->em->getRepository(User::class)->find($get['idJugador']);
                $imagen = $this->em->getRepository(Imagenes::class)->find($idImagen[0]['id']);
                $partida->setUsuarioId($jugador);
                $partida->setImagenesId($imagen);
                $this->em->persist($partida);
                $this->em->flush();
            }
        }
        $urlImagen = $this->em->getRepository(Imagenes::class)->findUrlImagen($idImagen);
        return $this->render('jugar/index.html.twig', [
            'sala' => $sala,
            'url' => $urlImagen,
            'palabrasUsuario'=>[],
            'idImagen'=>$idImagen
        ]);
    }

    /**
     * @Route("/guardar-palabras",name="app_guardar_palabras", options={"expose"=true})
     */
    public function palabraRelacionadaIndex(Request $request)
    {
        $idUsuario = $this->getUser()->getId();
        $get =$request->query->all();
        $palabraForm = $request->request->get('palabra');
        $idImagen = $get['idImagen'];
        $usuario = $this->getUser();
        $palabraExiste = $this->em->getRepository(UsuarioPalabras::class)->findByPalabraExiste($palabraForm, $idUsuario);
        if($palabraExiste){
            return new JsonResponse(['palabra'=>'existe', 'imagen'=>$idImagen]);
        }else{
            $palabraCorrecta = $this->em->getRepository(Palabra::class)->findByPalabraCorrecta($palabraForm, $idImagen);
            if ($request->isXmlHttpRequest()) {
                $resultado = $palabraCorrecta ? 'CORRECTO' : 'INCORRECTO';
                $palabraRelacionada = new UsuarioPalabras($palabraForm, $resultado);
                $palabraRelacionada->setIdUsuario($usuario);
                $this->em->persist($palabraRelacionada);
                $this->em->flush();
                return new JsonResponse(['palabra'=>$palabraForm, 'imagen'=>$idImagen] );
            } else {
                throw new \Exception(' :-( ');
            }
        }
    }

    /**
     *@Route("/resultados-parciales", name="app_resultados_parciales", options={"expose"= true})
     */
    public function resultadosParcialesIndex(){
        $usuario = $this->getUser()->getId();
        $palabrasUsuario = $this->em->getRepository(UsuarioPalabras::class)->findPalabras($usuario);
        return $this->render('jugar/resultadosParciales.html.twig',[
            'palabrasUsuario'=>$palabrasUsuario
        ]);
    }

    /**
     *@Route("/contador-usuarios", name="app_contador_usuarios", options={"expose" = true})
     */
    public function contadorUsuarios(Request $request){
        $idSala = $request->request->get('idSala');
        $jugadoresSala = $this->em->getRepository(Partidas::class)->findUsuariosSalas($idSala);

        return new JsonResponse(['sala'=>count($jugadoresSala)]);

    }
}
