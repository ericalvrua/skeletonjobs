<?php

namespace App\Controller;

use App\Entity\Empresas;
use App\Entity\Usuarios;
use App\Form\EmpresasType;
use App\Repository\EmpresasRepository;
use App\Repository\OfertasRepository;
use App\Repository\PreguntasRepository;
use App\Repository\RespuestasRepository;
use App\Repository\UsuariosEmpresasOfertasRepository;
use App\Repository\UsuariosRepository;
use App\Service\Correos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Mime\Email;

/**
 * @Route("/empresas")
 */
class EmpresasController extends AbstractController
{
    /**
     * Lista de las empresas
     * @Route("/", name="empresas_index", methods={"GET"})
     */
    public function index(EmpresasRepository $empresasRepository): Response
    {

        return $this->render('empresas/index.html.twig', [
            'empresas' => $empresasRepository->findAll(),
        ]);
    }

    /**
     * Funcion para crear una nueva empresa
     * @Route("/crear", name="empresas_crear", methods={"GET","POST"})
     */
    public function crearEmpresa(Request $request, EntityManagerInterface $em): Response
    {
        $empresa = new Empresas();
        $cif = $request->request->get('cif');
        $nombre = $request->request->get('nombre');
        $pass = $request->request->get('pass');
        $pass2 = $request->request->get('pass2');
        $correo = $request->request->get('correo');
        $correo2 = $request->request->get('correo2');
        $telefono = $request->request->get('telefono');
        // Comprobamos que tanto los correos como las contraseñas coinciden
        if ($pass == $pass2 && $correo == $correo2) {
            if (!empty($nombre)) {

                $em = $this->getDoctrine()->getManager();
                $empresa->setCif($cif);
                $empresa->setNombre($nombre);
                // Ciframos la contraseña
                $empresa->setPass(password_hash($pass, PASSWORD_DEFAULT));
                $empresa->setCorreo($correo);
                $empresa->setTelefono($telefono);
                $em->persist($empresa);
                $em->flush();
                return $this->redirectToRoute('empresas_crear');
            }
        }
        return $this->render('empresas/crear.html.twig', [
            'empresa' => $empresa
        ]);
    }

    /**
     * Funcion que permite a la empresa logearse 
     * @Route("/login", name="empresas_login", methods={"GET", "POST"})
     */
    public function empresasLogin(EmpresasRepository $empresasRepository, EntityManagerInterface $em, Request $request, SessionInterface $session): Response
    {
        $correo = $request->request->get('correo');
        $pass = $request->request->get('pass');
        $empresa = $empresasRepository->findOneBy(['correo' => $correo]);

        
        if ($request->request->get('correo') != "") {
            // Si la empresa existe, comprobamos las contraseñas.
            if (!empty($empresa)) {
                if (password_verify($pass, $empresa->getPass())) {
                    $session->set('empresa', ['correo' => $empresa->getCorreo(), 'id' => $empresa->getId()]);
                    return $this->redirectToRoute('empresas_perfil');
                } else {
                    // En caso de ser erronea la contraseña devolvemos a la pagina con ese mensaje
                    return $this->render('empresas/login.html.twig', [
                        'usuarios' => $empresasRepository->findAll(),
                        'error' => 'Error: contraseña incorrecta',
                    ]);
                }
            } else {
                // Si no existe el correo devolvemos al login con un mensaje de error
                return $this->render('empresas/login.html.twig', [
                    'usuarios' => $empresasRepository->findAll(),
                    'error' => 'Error: el correo indicado no existe',
                ]);
            }
        }

        return $this->render('empresas/login.html.twig', [
            'empresas' => $empresasRepository->findAll(),
        ]);
    }

    /**
     * Genera el perfil de una empresa
     * @Route("/perfil", name="empresas_perfil", methods={"GET"})
     */
    public function empresasPerfil(EmpresasRepository $empresasRepository, SessionInterface $session): Response
    {
        return $this->render('empresas/perfil.html.twig', [
            'empresa' => $empresasRepository->findOneBy(['correo' => $session->get('empresa')['correo']]),
        ]);
    }

    /**
     * Cierra la sesion de una empresa
     * @Route("/cerrarSesion", name="empresas_cerrar_sesion", methods={"GET"})
     */
    public function empresasCerrarSesion(EmpresasRepository $empresasRepository, SessionInterface $session): Response
    {
        $session->remove('empresa'); // Eliminamos la sesion actual de la empresa
        return $this->render('empresas/login.html.twig', [
            'empresas' => $empresasRepository->findAll(),
        ]);
    }


    /**
     * Funcion que permite editar los datos de una empresa
     * @Route("/editar", name="empresas_editar", methods={"GET","POST"})
     */
    public function editar(Request $request, EmpresasRepository $empresasRepository, SessionInterface $session): Response
    {
        $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]);
        if ($request->get('nombre')) {
            $nombre = $request->get('nombre');
            $telefono = $request->get('telefono');
            if (!empty($nombre) && !empty($telefono)) {
                $em = $this->getDoctrine()->getManager();
                $empresa->setNombre($nombre);
                $empresa->setTelefono($telefono);
                // Si en el request no esta vacio, hacemos set al valor, en caso contrario no hacemos nada
                !empty($request->get('direccion')) ? $empresa->setDireccion($request->get('direccion')) : null;
                !empty($request->get('codigo_postal')) ? $empresa->setCodigoPostal($request->get('codigo_postal')) : null;
                !empty($request->get('pais')) ? $empresa->setPais($request->get('pais')) : null;
                !empty($request->get('provincia')) ? $empresa->setProvincia($request->get('provincia')) : null;
                !empty($request->get('localidad')) ? $empresa->setLocalidad($request->get('localidad')) : null;
                !empty($request->get('descripcion')) ? $empresa->setDescripcion($request->get('descripcion')) : null;
                $em->persist($empresa);
                $em->flush();
                return $this->redirectToRoute('empresas_perfil');
            }
        }


        return $this->render('empresas/editar.html.twig', [
            'empresa' => $empresa,
        ]);
    }

    /**
     * Esta funcion permitira descartar a un usuario de una oferta de la empresa
     * @Route("/descartarUsuario/{idOferta}/{idUsuario}", name="empresas_descartar", methods={"GET","POST"})
     * idOferta = indica el id de la oferta
     * idUsuario = indica el id del usuario a descartar
     */
    public function descartarUsuario($idOferta, $idUsuario, UsuariosEmpresasOfertasRepository $triple, SessionInterface $session, OfertasRepository $ofertasRepository, UsuariosRepository $usuariosRepository, EntityManagerInterface $em, MailerInterface $mailer, EmpresasRepository $empresasRepository, Correos $correos): Response
    {
        $usuario = $usuariosRepository->findOneBy(['id' => $idUsuario]);
        $oferta = $ofertasRepository->findOneBy(['id' => $idOferta]);
        $oferta_usuario = $triple->findOneBy(['ofertas' => $oferta, 'usuarios' => $usuario]);
        $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]);
        $em = $this->getDoctrine()->getManager();
        $oferta_usuario->setDescartado(true);
        // Poner email
        $mensaje = "<p>Has sido descartado de una oferta a la que se encontraba inscrito.</p>";
        $asunto = "Oferta declinada";

        $correos->crearCorreo($usuario->getCorreo(), $empresa, $oferta, $asunto, $mensaje);


        $em->persist($oferta_usuario);
        $em->flush();

        return $this->redirectToRoute('ofertas_listaempresas');
    }


    /**
     * Muestra la informacion de una empresa
     * @Route("/{id}", name="empresas_show", methods={"GET"})
     */
    public function show(Empresas $empresa): Response
    {
        return $this->render('empresas/show.html.twig', [
            'empresa' => $empresa,
        ]);
    }

    /**
     * Funcion que nos permite mostrar las respuestas que un usuario a realizado a la pregunta
     * @Route("/respuestas/{idOferta}/{idUsuario}", name="empresas_respuestas", methods={"GET","POST"})
     * idOferta e idUsuario son los id de la oferta y del usuario respectivamente, que usaremos para llegar a las respuestas
     */
    public function verRespuestas(Request $request, $idOferta, $idUsuario, PreguntasRepository $preguntasRepository, OfertasRepository $ofertasRepository, RespuestasRepository $respuestasRepository, UsuariosRepository $usuariosRepository ): Response
    {
        // Buscamos las preguntas relacionadas con la oferta
        $preguntas = $preguntasRepository->findBy(['oferta' => $ofertasRepository->findOneBy(['id' => $idOferta])]);

        for ($i = 0; $i < count($preguntas); $i++) {
            // Guardamos la respuesta que ha realizado el usuario a cada pregunta.
            $respuestas[$i] = $respuestasRepository->findOneBy(['pregunta' => $preguntas[$i], 'usuario' => $usuariosRepository->findOneBy(['id' => $idUsuario])]);

        }
        
        return $this->render('empresas/respuestas.html.twig', [
            'preguntas' => $preguntas,
            'respuestas' => $respuestas
        ]);
    }

}