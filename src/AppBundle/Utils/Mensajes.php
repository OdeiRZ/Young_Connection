<?php

namespace AppBundle\Utils;

use AppBundle\Controller\DefaultController;
use AppBundle\Entity\Mensaje;
use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class Mensajes extends Controller
{
    static public function obtenerMensajesNoLeidos(Controller $controlador, Container $container, Usuario $usuario)
    {
        $em = $controlador->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Mensaje')
                 ->createQueryBuilder('m')
                 ->select('COUNT(m)')
                 ->where('m.estaRecibido = 0')
                 ->andWhere('m.usuarioDestino = :id')
                 ->setParameter('id', $usuario->getId());
        $mensajes = $qb->getQuery()->getSingleScalarResult();
        return $mensajes;
    }
    static public function actualizarMensajesNoLeidos(Controller $controlador, Container $container, Usuario $usuario)
    {
        $em = $controlador->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Mensaje')
                 ->createQueryBuilder('m')
                 ->where('m.estaRecibido = 0')
                 ->andWhere('m.usuarioDestino = :id')
                 ->setParameter('id', $usuario->getId());
        $mensajes = $qb->getQuery()
                       ->getResult();
        foreach ($mensajes as $mensaje) {
            $mensaje->setEstaRecibido(1);
            $em->flush();
        }
    }
}