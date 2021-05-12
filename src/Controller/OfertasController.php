<?php

namespace App\Controller;

use App\Entity\Ofertas;
use App\Entity\Preguntas;
use App\Entity\Respuestas;
use App\Entity\UsuariosEmpresasOfertas;
use App\Form\OfertasType;
use App\Repository\CategoriasRepository;
use App\Repository\EmpresasRepository;
use App\Repository\IslasRepository;
use App\Repository\OfertasRepository;
use App\Repository\PreguntasRepository;
use App\Repository\RespuestasRepository;
use App\Repository\UsuariosEmpresasOfertasRepository;
use App\Repository\UsuariosRepository;
use App\Service\Correos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

/**
 * @Route("/ofertas")
 */
class OfertasController extends AbstractController
{
    /**
     * Funcion que genera la lista de las ofertas.
     * @Route("/lista", name="ofertas_index", methods={"GET", "POST"})
     */
    public function index(OfertasRepository $ofertasRepository, Request $request, CategoriasRepository $categoriasRepository, IslasRepository $islasRepository): Response
    {

        // Lista de ofertas con un parametro de busqueda
        if ($request->get('busqueda') != "") {
            return $this->render('ofertas/index.html.twig', [
                'ofertas' => $ofertasRepository->ofertasBusqueda($request->get('busqueda')),
                'categorias' => $categoriasRepository->findAll(),
                'islas' => $islasRepository->findAll()
            ]);
        }

        // Lista de ofertas eligiendo una categoria
        if ($request->query->get('categorias') != "") {
            return $this->render('ofertas/index.html.twig', [
                'ofertas' => $ofertasRepository->ofertasCategorias($request->query->get('categorias')),
                'categorias' => $categoriasRepository->findAll(),
                'islas' => $islasRepository->findAll()
            ]);
        }

        // Lista de ofertas eligiendo una fecha
        if ($request->query->get('fecha1') != "" && $request->query->get('fecha2') != "") {
            return $this->render('ofertas/index.html.twig', [
                'ofertas' => $ofertasRepository->ofertasFecha($request->query->get('fecha1'), $request->query->get('fecha2')),
                'categorias' => $categoriasRepository->findAll(),
                'islas' => $islasRepository->findAll()
            ]);
        }
        // Lista de oferta si esta activa o no
        if ($request->query->get('actividad') != "") {
            return $this->render('ofertas/index.html.twig', [
                'ofertas' => $ofertasRepository->ofertasActividad($request->query->get('actividad')),
                'categorias' => $categoriasRepository->findAll(),
                'islas' => $islasRepository->findAll()
            ]);
        }
        // Lista de ofertas si has elegido una isla
        if ($request->query->get('localizacion') != "") {

            return $this->render('ofertas/index.html.twig', [
                'ofertas' => $ofertasRepository->ofertasLoc($request->query->get('localizacion')),
                'categorias' => $categoriasRepository->findAll(),
                'islas' => $islasRepository->findAll()
            ]);
        }

        // Lista de ofertas por defecto
        return $this->render('ofertas/index.html.twig', [
            'ofertas' => $ofertasRepository->findAll(),
            'categorias' => $categoriasRepository->findAll(),
            'islas' => $islasRepository->findAll()
        ]);
    }

    /**
     * Lista de las ofertas a las que esta inscrito un usuario
     * @Route("/listaUsuario", name="ofertas_listausuario", methods={"GET"})
     */
    public function listaUsuario(OfertasRepository $ofertasRepository, SessionInterface $session, UsuariosRepository $usuariosRepository, UsuariosEmpresasOfertasRepository $triple): Response
    {
        $usuario = $usuariosRepository->findOneBy(['id' => $session->get('usuario')['id']]);

        return $this->render('ofertas/listaUsuario.html.twig', [
            'ofertas' => $triple->findBy(['usuarios' => $usuario]),
        ]);
    }

    /**
     * Genera la lista de las ofertas que ha creado una empresa
     * @Route("/listaEmpresas", name="ofertas_listaempresas", methods={"GET"})
     */
    public function listaEmpresas(OfertasRepository $ofertasRepository, SessionInterface $session, EmpresasRepository $empresasRepository): Response
    {
        $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]);

        return $this->render('ofertas/listaEmpresa.html.twig', [
            'ofertas' => $ofertasRepository->findBy(['id_empresa' => $empresa]),
        ]);
    }


    /**
     * Funcion para crear una oferta
     * @Route("/crear", name="ofertas_crear", methods={"GET","POST"})
     */
    public function crearOferta(Request $request, EntityManagerInterface $em, SessionInterface $session, CategoriasRepository $categoriasRepository, EmpresasRepository $empresasRepository, IslasRepository $islasRepository): Response
    {
        $oferta = new Ofertas();
        $descripcion = $request->request->get('descripcion');
        $puesto = $request->request->get('puesto');
        $fecha = new \DateTime();
        $tipo = $request->request->get('tipo');
        $categoria = $request->request->get('categoria');
        $preguntas = $request->request->get('field_name');

        if (!empty($descripcion)) {

            $em = $this->getDoctrine()->getManager();
            //Añade al objeto Oferta los distintos campos necesarios
            $oferta->setDescripcion($descripcion);
            $oferta->setPuesto($puesto);
            $oferta->setFecha($fecha);
            $oferta->setTipo($tipo);
            $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]); //Recoge el id de la sesion de la empresa
            $oferta->setIdEmpresa($empresa);
            $categorias = $categoriasRepository->findOneBy(['id' => $categoria]); //Busca el id de la categoria
            $oferta->setCategoria($categorias);
            $oferta->setActivo(true);
            // Se marca si la oferta se ha guardado en borrador o no
            if ($request->get('guardar')) {
                $oferta->setBorrador(true);
            } else {
                $oferta->setBorrador(false);
            }
            //Añade las islas indicadas a la oferta.
            for ($i = 0; $i < 9; $i++) {
                if ($request->get('isla' . $i) != "") {
                    $oferta->addIsla($islasRepository->findOneBy(['id' => $request->get('isla' . $i)]));
                }
            }

            $em->persist($oferta);
            $em->flush();
            // Creacion de las preguntas.
            foreach ($preguntas as $valor) {
            // Si la pregunta esta vacia, no se guarda
                if ($valor !=  "") {
                    $pregunta = new Preguntas();
                    $pregunta->setPregunta($valor);
                    $pregunta->setRequerido(true);
                    $pregunta->setOferta($oferta);
                    $em->persist($pregunta);
                    $em->flush();
                }
            }
            
            return $this->redirectToRoute('empresas_perfil');
        }
        return $this->render('ofertas/crear.html.twig', [
            'oferta' => $oferta,
            'categorias' => $categoriasRepository->findAll(),
            'islas' => $islasRepository->findAll()
        ]);
    }


    /**
     * Funcion para que un usuario se registre en una oferta
     * @Route("/registro", name="ofertas_registro", methods={"GET","POST"})
     */
    public function registroOferta(Request $request, EntityManagerInterface $em, SessionInterface $session, EmpresasRepository $empresasRepository, UsuariosRepository $usuariosRepository, OfertasRepository $ofertasRepository, MailerInterface $mailer, PreguntasRepository $preguntasRepository, Correos $correos): Response
    {

        $registro = new UsuariosEmpresasOfertas();

        $usuario = $usuariosRepository->findOneBy(['id' => $session->get('usuario')['id']]);
        $idempresa = $request->request->get('idempresa');
        $idoferta = $request->request->get('idoferta');
        $correo = $usuario->getCorreo();
        $empresa = $empresasRepository->findOneBy(['id' => $idempresa]);
        $oferta = $ofertasRepository->findOneBy(['id' => $idoferta]);
        $respuestas = $request->request->get('respuesta');
        $preguntas = $request->request->get('preguntaid');

        if (!empty($oferta)) {
            $em = $this->getDoctrine()->getManager();
            $registro->setIdEmpresa($empresa);
            $registro->setOfertas($oferta);
            $registro->setUsuarios($usuario);
            // Se añaden las respuestas a las preguntas realizadas
            if ($respuestas != "") {
                for ($i = 0; $i < count($respuestas); $i++) {
                    $respuesta = new Respuestas();
                    $respuesta->setRespuesta($respuestas[$i]);
                    $respuesta->setUsuario($usuario);
                    $respuesta->setPregunta($preguntasRepository->findOneBy(['id' => $preguntas[$i]]));
                    $em->persist($respuesta);
                    $em->flush();
                }
            }
            $em->persist($registro);
            $em->flush();

            // Manda un correo al usuario confirmando que se ha registrado en la oferta
            $mensaje = '<p>¡Te has registrado a una nueva oferta de Skeleton Jobs! </p>';
            $asunto = 'Se ha registrado en una oferta';
            $correos->crearCorreo($correo, $empresa, $oferta, $asunto, $mensaje);
        }
        return $this->redirectToRoute("ofertas_index");
    }

    /**
     * Funcion que genera la pagina donde se realizan las preguntas de una oferta al usuario
     * @Route("/preguntas", name="ofertas_preguntas", methods={"GET","POST"})
     */
    public function preguntasOferta(Request $request, SessionInterface $session, UsuariosRepository $usuariosRepository, PreguntasRepository $preguntasRepository): Response
    {
        $usuario = $usuariosRepository->findOneBy(['id' => $session->get('usuario')['id']]);
        $idempresa = $request->request->get('idempresa');
        $idoferta = $request->request->get('idoferta');

        // Si no hay preguntas en la oferta, se redirige a la funcion de registrar a un usuario
        if (count($preguntasRepository->findBy(['oferta' => $idoferta])) == 0) {
            // forward nos permite redirigir un request a otra funcion
            return $this->forward('App\Controller\OfertasController::registroOferta', [
                'request' => $request
            ]);
        }

        return $this->render('ofertas/preguntas.html.twig', [
            'preguntas' => $preguntasRepository->findBy(['oferta' => $idoferta]),
            'idempresa' => $idempresa,
            'idoferta' => $idoferta
        ]);
    }

    /**
     * Funcion para editar una oferta. 
     * @Route("/editar/{id}", name="ofertas_editar", methods={"GET","POST"})
     * id = el id de la oferta a editar.
     */
    public function editar(Request $request, OfertasRepository $ofertasRepository, SessionInterface $session, EmpresasRepository $empresasRepository, $id, CategoriasRepository $categoriasRepository, IslasRepository $islasRepository, PreguntasRepository $preguntasRepository): Response
    {

        $oferta = $ofertasRepository->findOneBy(['id' => $id]);
        $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]);
        // Comprobamos si la oferta es propiedad de la empresa en sesion.
        
        if ($empresa != $oferta->getIdEmpresa()) {
            return $this->redirectToRoute('index');
        }

        if ($request->get('descripcion')) {
            $descripcion = $request->get('descripcion');
            $puesto = $request->get('puesto');
            $tipo = $request->get('tipo');
            $categoria = $request->request->get('categoria');
            $provincia = $request->request->get('provincia');
            $preguntas = $request->request->get('field_name');

            if (!empty($descripcion) && !empty($puesto) && !empty($tipo)) {
                $em = $this->getDoctrine()->getManager();
                // Comprueba si se va a guardar en borrador o no
                if ($request->get('guardar')) {
                    $oferta->setBorrador(true);
                } else {
                    $oferta->setBorrador(false);
                }
                // Borra las islas que hubiera previamente
                $islas = $oferta->getIslas();
                for ($i = 0; $i < count($islas); $i++) {
                    $oferta->removeIsla($islas[$i]);
                }
                // Añade a las islas a la oferta
                for ($i = 0; $i < 9; $i++) {
                    if ($request->get('isla' . $i) != "") {
                        $oferta->addIsla($islasRepository->findOneBy(['id' => $request->get('isla' . $i)]));
                    }
                }

                $oferta->setDescripcion($descripcion);
                $oferta->setPuesto($puesto);
                $oferta->setTipo($tipo);
                $categorias = $categoriasRepository->findOneBy(['id' => $categoria]);
                $oferta->setCategoria($categorias);
                $oferta->setProvincia($provincia);

                $em->persist($oferta);
                $em->flush();
                // Añade las preguntas a la oferta
                foreach ($preguntas as $valor) {
                    if ($valor != "") {
                        $pregunta = new Preguntas();
                        $pregunta->setPregunta($valor);
                        $pregunta->setRequerido(true);
                        $pregunta->setOferta($oferta);
                        $em->persist($pregunta);
                        $em->flush();
                    }
                }
                return $this->redirectToRoute('ofertas_listaempresas');
            }
        }

        return $this->render('ofertas/editar.html.twig', [
            'oferta' => $oferta,
            'categorias' => $categoriasRepository->findAll(),
            'islas' => $islasRepository->findAll(),
            'preguntas' => $preguntasRepository->findBy(['oferta' => $oferta])

        ]);
    }

    /**
     * Muestra la informacion de una oferta.
     * @Route("/{id}", name="ofertas_show", methods={"GET", "POST"})
     */
    public function show(Ofertas $oferta, SessionInterface $session, OfertasRepository $ofertasRepository, UsuariosEmpresasOfertasRepository $triple, UsuariosRepository $usuariosRepository): Response
    {
        // Redirige si la oferta esta en borrador
        if ($oferta->getBorrador() == true) {
            return $this->redirectToRoute('ofertas_index');
        }

        // Como se renderiza cuando no esta registrado como usuario
        if ($session->get('usuario') == "") {
            return $this->render('ofertas/show.html.twig', [
                'oferta' => $oferta,
                'registrado' => false
            ]);
        }

        // Comprobacion de si el usuario ya esta inscrito en la oferta
        $ofertas = $triple->findBy(['usuarios' => $usuariosRepository->findOneBy(['id' => $session->get('usuario')['id']]), 'ofertas' => $oferta]);
        $registrado = false;
        // Si el usuario esta inscrito, registrado lo pasaremos a true
        if (count($ofertas) > 0) {
            $registrado = true;
        }
        $numeroUsuarios = count($triple->findBy(['ofertas' => $oferta])); // Numero de usuarios que se encuentran inscritos en la oferta.


        return $this->render('ofertas/show.html.twig', [
            'oferta' => $oferta,
            'registrado' => $registrado,
            'numeroUsuarios' => $numeroUsuarios
        ]);
    }


    /**
     * Le muestra a la empresa los usuarios que estan inscritos en una oferta
     * @Route("/listaEmpresas/{id}", name="ofertas_usuarios_inscritos", methods={"GET"})
     */
    public function usuariosInscritosOferta(UsuariosEmpresasOfertasRepository $triple, $id, OfertasRepository $ofertasRepository, EmpresasRepository $empresasRepository, SessionInterface $session): Response
    {
        // Comprobacion de si es la empresa propietaria de la oferta.
        $empresa = "";
        $ofertas = $ofertasRepository->findOneBy(['id' => $id]);

        if ($session->get('empresa') != "") {
            $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]);
        }

        if ($empresa != $ofertas->getIdEmpresa()) {
            return $this->redirectToRoute('index');
        }

        return $this->render('ofertas/usuariosInscritos.html.twig', [
            'ofertas' => $triple->findBy(['ofertas' => $ofertas]),
        ]);
    }

    /**
     * Funcion que nos permite borrar una oferta
     * @Route("/delete/{id}", name="ofertas_delete",  methods={"GET","POST"})
     */
    public function delete(Request $request, OfertasRepository $ofertasRepository, $id, EmpresasRepository $empresasRepository, UsuariosEmpresasOfertasRepository $triple, SessionInterface $session, MailerInterface $mailer, PreguntasRepository $preguntasRepository, RespuestasRepository $respuestasRepository, Correos $correos): Response
    {
        $usuario = $triple->findBy(['ofertas' => $ofertasRepository->findOneBy(['id' => $id])]);



        $oferta = $ofertasRepository->findOneBy(['id' => $id]);
        $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]);
        // Comprobacion de que la oferta es propiedad de la empresa en sesion
        if ($empresa != $oferta->getIdEmpresa()) {
            return $this->redirectToRoute('index');
        }


        $entityManager = $this->getDoctrine()->getManager();
        // Borrar las preguntas y las respuestas de una oferta.
        $preguntas = $preguntasRepository->findBy(['oferta' => $oferta]);
        for ($i = 0; $i < count($preguntas); $i++ ) {
            $respuestas = $respuestasRepository->findBy(['pregunta' => $preguntas[$i]]);
            for ($j = 0; $j < count($respuestas); $j++) {
                $entityManager->remove($respuestas[$j]);
            }
            $entityManager->remove($preguntas[$i]);
        }

        $entityManager->remove($oferta);
        $entityManager->flush();


        // Mandar correo avisando a los usuarios inscritos en la oferta
        
        $mensaje = '<p>La siguiente oferta en la que estabas inscrito ha sido eliminada</p>';
        $asunto = 'Oferta eliminada';
        for ($i = 0; $i < count($usuario); $i++) {
            $correo = $usuario[$i]->getUsuarios()->getCorreo();
            $correos->crearCorreo($correo, $empresa, $oferta, $asunto, $mensaje, false);
        }

        return $this->redirectToRoute('ofertas_listaempresas');
    }



    /**
     * Funcion para cerrar una oferta.
     * @Route("/cerrar/{id}", name="ofertas_cerrar", methods={"GET","POST"})
     */
    public function cerrar(Request $request, EntityManagerInterface $em, $id = null, SessionInterface $session, MailerInterface $mailer, EmpresasRepository $empresasRepository, OfertasRepository $ofertasRepository, UsuariosEmpresasOfertasRepository $triple, Correos $correos): Response
    {

        $oferta = $ofertasRepository->findOneBy(['id' => $id]);
        $empresa = $empresasRepository->findOneBy(['id' => $session->get('empresa')['id']]);
        // Comprobacion de que la oferta es propiedad de la empresa en sesion
        if ($empresa != $oferta->getIdEmpresa()) {
            return $this->redirectToRoute('index');
        }

        // Buscamos a todos los usuarios inscritos en la oferta para recoger su correo
        $entityManager = $this->getDoctrine()->getManager();
        $ofertasTriple = $triple->findBy(['ofertas' => $oferta]);

        $correo = array();
        foreach ($ofertasTriple as &$ofertaLinea) {
            array_push($correo, $ofertaLinea->getUsuarios()->getCorreo());
        }


        $mensaje = "<p>La siguiente oferta a la que se encontraba inscrito ha sido cerrada.</p>";
        $asunto = "Oferta terminada";
        for ($i = 0; $i < count($correo); $i++) {
            $correos->crearCorreo($correo[$i], $empresa, $oferta, $asunto, $mensaje);
        }

        // Cambiamos el activo de la oferta a falso
        $oferta->setActivo(false);
        $entityManager->persist($oferta);
        $entityManager->flush();
        return $this->redirectToRoute('ofertas_listaempresas');
    }
}
