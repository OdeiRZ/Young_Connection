<?php

namespace AppBundle\Utils;

use AppBundle\Controller\DefaultController;
use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;

class Notificaciones
{
    static public function notificarRegistro(Controller $controlador, \Swift_Mailer $mailer, Container $container, Usuario $usuario)
    {
        if ($usuario->getCorreoElectronico()) {
            $mensaje = $mailer->createMessage()
                ->setSubject($container->getParameter('prefijo_notificacion') . ' Bienvenido a la Plataforma ' . $usuario->getNombre() . ' ' . $usuario->getApellidos())
                ->setFrom($container->getParameter('remite_notificacion'))
                ->setTo([$usuario->getCorreoElectronico()])
                ->setBody( "Te damos la bienvenida al portal Young Connection.\n\n\nRecuerda que tu usuario sera tu correo electrónico: " . $usuario->getCorreoElectronico() . ".\n\n\nEsperamos que disfrutes de tu estancia.", 'text/plain');
            $mailer->send($mensaje);
        }
    }
    static public function notificarRegeneracion(Controller $controlador, \Swift_Mailer $mailer, Container $container, Usuario $usuario, $nuevaClave)
    {
        if ($usuario->getCorreoElectronico()) {
            $mensaje = $mailer->createMessage()
                ->setSubject($container->getParameter('prefijo_notificacion') . ' Regeneración de Contraseña')
                ->setFrom($container->getParameter('remite_notificacion'))
                ->setTo([$usuario->getCorreoElectronico()])
                ->setBody( "Se ha procesadocd correctamente su petición de Regeneración de Contraseña.\n\n\nTe Recordamos que tu usuario seguirá siendo tu correo electrónico: " . $usuario->getCorreoElectronico() . ".\nSe te ha asignado la nueva clave: " . $nuevaClave. "\n\n\nEsperamos que disfrutes de tu estancia.", 'text/plain');
            $mailer->send($mensaje);
        }
    }
}