<?php


namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Correos {
    private $mailer;
    private $url;

    public function __construct(MailerInterface $mailer, UrlGeneratorInterface $url)
    {
        $this->mailer = $mailer;
        $this->url = $url;
    }
    /*Esta funcion permite enviar correos segun unos parametros
    * $generarLink nos indicara si tendremos que crear o no el enlace a la oferta
    * $enviar sera si el correo es un mensaje que tiene que enviar la empresa al usuario.
    */
    public function crearCorreo( $correo, $empresa, $oferta, $asunto, $mensaje, $generarLink = true, $enviar = false) {

        $datos = '
        <p>Datos de la oferta:</p>
        <p> <b>Empresa: </b> '.$empresa->getNombre().'</p>
        <p> <b>Puesto</b>: '.$oferta->getPuesto().'</p>
        <p> <b>Descripcion</b>: '.$oferta->getDescripcion().' </p>
        <p> <b>Tipo</b>: '.$oferta->getTipo().'</p>';

        if ($generarLink == true) {
            $link = $this->url->generate('ofertas_show', ['id' => $oferta->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            $datos = $datos.'<a href="'.$link.'">Enlace a esta oferta</a>';
        } 
        $mensajeEnviar = '';
        
        
        // Cuando sea enviar un correo a un usuario.
        if ($enviar == true) {
            $mensajeEnviar = '<p>Este correo fue enviado por <b>'.$empresa->getNombre().'</b>, sobre <a href="'.$link.'">la siguiente oferta</a>. El mensaje dice:</p>';
            $link = "";
            $datos = "";
        }

        $email = (new Email())
                ->from('proyectoskeleton@gmail.com')
                ->to($correo)
                ->subject($asunto)
                ->text('Sending emails is fun again!')
                ->html("$mensajeEnviar $mensaje $datos");

            if($enviar == true) {
                $correoEmpresa = $empresa->getCorreo();
                $email->cc($correoEmpresa);
            }

            $this->mailer->send($email);
        }
    }
?>