<?php

namespace App\Controller;

use App\Repository\OfertasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{
    /**
     * Genera el inicio de la pagina
     * @Route("/", name="index")
     */
    public function index(OfertasRepository $ofertasRepository): Response
    {      
        return $this->render('index.html.twig', [
            'ofertas' => $ofertasRepository->ofertasLimite()
        ]);
    }
}
