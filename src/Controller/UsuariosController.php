<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\UsuariosType;
use App\Repository\EmpresasRepository;
use App\Repository\OfertasRepository;
use App\Repository\UsuariosRepository;
use App\Service\Correos;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/usuarios")
 */
class UsuariosController extends AbstractController
{
    /**
     * Funcion que nos permitira logear a un usuario
     * @Route("/login", name="usuarios_login", methods={"GET", "POST"})
     */
    public function usuariosLogin(UsuariosRepository $usuariosRepository, EntityManagerInterface $em, Request $request, SessionInterface $session): Response
    {
        $correo = $request->request->get('correo');
        $pass = $request->request->get('pass');
        $usuario = $usuariosRepository->findOneBy(['correo' => $correo]);

        if ($request->request->get('correo') != "") {
            // Si el correo existe, comprobamos las contraseñas y creamos la sesion del usuario
            if (!empty($usuario)) {
                if (password_verify($pass, $usuario->getPass())) {
                    $session->set('usuario', ['correo' => $usuario->getCorreo(), 'id' => $usuario->getId()]);
                    return $this->redirectToRoute('usuarios_perfil');
                } else {
                    // Si es incorrecta la contraseña, se devuelve a la pagina con un error
                    return $this->render('usuarios/login.html.twig', [
                        'usuarios' => $usuariosRepository->findAll(),
                        'error' => 'Error: contraseña incorrecta',
                    ]);
                }
            } else {
                // Si es incorrecto el correo, se devuelve a la pagina con un error
                return $this->render('usuarios/login.html.twig', [
                    'usuarios' => $usuariosRepository->findAll(),
                    'error' => 'Error: el correo indicado no existe',
                ]);
            }
        }

        return $this->render('usuarios/login.html.twig', [
            'usuarios' => $usuariosRepository->findAll(),
        ]);
    }

    /**
     * Genera el perfil de un usuario
     * @Route("/perfil", name="usuarios_perfil", methods={"GET"})
     */
    public function usuariosPerfil(UsuariosRepository $usuariosRepository, SessionInterface $session): Response
    {
        return $this->render('usuarios/perfil.html.twig', [
            'usuario' => $usuariosRepository->findOneBy(['correo' => $session->get('usuario')['correo']]),
        ]);
    }

    /**
     * Cierra la sesion de un usuario
     * @Route("/cerrarSesion", name="usuarios_cerrar_sesion", methods={"GET"})
     */
    public function usuariosCerrarSesion(UsuariosRepository $usuariosRepository, SessionInterface $session): Response
    {
        $session->remove('usuario'); // Elimina la sesion del usuario
        return $this->render('usuarios/login.html.twig', [
            'usuarios' => $usuariosRepository->findAll(),
        ]);
    }

    /**
     * Funcion que permite la creacion de un usuario.
     * @Route("/crear", name="usuarios_crear", methods={"GET","POST"})
     */
    public function crearUsuario(Request $request, EntityManagerInterface $em): Response
    {
        $usuario = new Usuarios();
        $nombre = $request->request->get('nombre');
        $identificacion = $request->request->get('identificacion');
        $apellidos = $request->request->get('apellidos');
        $pass = $request->request->get('pass');
        $pass2 = $request->request->get('pass2');
        $correo = $request->request->get('correo');
        $correo2 = $request->request->get('correo2');
        $fecha_nacimiento = $request->request->get('fecha_nacimiento');
        $telefono = $request->request->get('telefono');
        // Comprobacion de que tanto los correos como las contraseñas son iguales
        if ($pass == $pass2 && $correo == $correo2) {
            if (!empty($nombre)) {

                $em = $this->getDoctrine()->getManager();
                $usuario->setNombre($nombre);
                $usuario->setDni($identificacion);
                $usuario->setApellidos($apellidos);
                $usuario->setPass(password_hash($pass, PASSWORD_DEFAULT));
                $usuario->setCorreo($correo);
                // Colocamos la fecha de nacimiento de la siguiente manera
                $usuario->setFechaNacimiento(\DateTime::createFromFormat('Y-m-d', $fecha_nacimiento));
                $usuario->setTelefono($telefono);
                $em->persist($usuario);
                $em->flush();
                return $this->redirectToRoute('usuarios_crear');
            }
        }
        return $this->render('usuarios/crear.html.twig', [
            'usuario' => $usuario
        ]);
    }

    /**
     * Esta funcion nos permite editar la informacion de un usuario.
     * @Route("/editar", name="usuarios_editar", methods={"GET","POST"})
     */
    public function editar(Request $request, UsuariosRepository $usuariosRepository, SessionInterface $session, SluggerInterface $slugger): Response
    {
        $usuario = $usuariosRepository->findOneBy(['id' => $session->get('usuario')['id']]);
        if ($request->get('nombre')) {
            $nombre = $request->get('nombre');
            $apellidos = $request->get('apellidos');
            $telefono = $request->get('telefono');
            if (!empty($nombre) && !empty($apellidos) && !empty($telefono)) {
                $em = $this->getDoctrine()->getManager();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setTelefono($telefono);
                // Si en el request no esta vacio, hacemos set al valor, en caso contrario no hacemos nada
                !empty($request->get('direccion')) ? $usuario->setDireccion($request->get('direccion')) : null;
                !empty($request->get('codigo_postal')) ? $usuario->setCodigoPostal($request->get('codigo_postal')) : null;
                !empty($request->get('pais')) ? $usuario->setPais($request->get('pais')) : null;
                !empty($request->get('provincia')) ? $usuario->setProvincia($request->get('provincia')) : null;
                !empty($request->get('localidad')) ? $usuario->setLocalidad($request->get('localidad')) : null;
                !empty($request->get('descripcion')) ? $usuario->setDescripcion($request->get('descripcion')) : null;

                //Subir CV
                if (!empty($request->files->get('cv'))) {
                    // Recogemos el fichero y tambien le creamos un nuevo nombre de forma segura
                    $archivo = $request->files->get('cv');
                    $originalFilename = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $archivo->guessExtension();

                    // Movemos el fichero a nuestra carpeta publica
                    $archivo->move('uploads/cv', $newFilename);

                    $usuario->setCv($newFilename);
                }

                $em->persist($usuario);
                $em->flush();
                return $this->redirectToRoute('usuarios_perfil');
            }
        }


        return $this->render('usuarios/editar.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * Esta funcion nos permite ver la informacion de un usuario.
     * @Route("/{id}", name="usuarios_show", methods={"GET"})
     */
    public function show(Usuarios $usuario): Response
    {
        return $this->render('usuarios/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * Esta funcion permitira mandar a las empresas un correo al usuario.
     * @Route("/crearCorreo/{idOferta}/{idUsuario}", name="usuarios_crearCorreo", methods={"GET", "POST"})
     */
    public function crearCorreo($idUsuario, $idOferta, Request $request, MailerInterface $mailer, SessionInterface $session, EmpresasRepository $empresasRepository, OfertasRepository $ofertasRepository, UsuariosRepository $usuariosRepository, Correos $correos): Response
    {
        if ($request->get('asunto') != "") {
            
            $oferta = $ofertasRepository->findOneBy(['id' => $idOferta]);
            $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]);
            // Comprobamos que la oferta es de la empresa que se encuentra en sesion
            if ($empresa != $oferta->getIdEmpresa()) {
                return $this->redirectToRoute('index');
            }

            $correoUsuario = $usuariosRepository->findOneBy(['id' => $idUsuario])->getCorreo();
            // Enviar correo
            $correos->crearCorreo($correoUsuario, $empresa, $oferta, $request->get('asunto'), $request->get('mensaje'), true, true);

        return $this->redirectToRoute('empresas_perfil');
        }

        return $this->render('usuarios/correo.html.twig', [
            'id' => $idUsuario,
            'oferta' => $idOferta
        ]);
    }

}
        