<?php

namespace AppBundle\Utils;

use AppBundle\Controller\DefaultController;
use AppBundle\Entity\Familia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;

class Familias extends Controller
{
    static public function actualizarFamiliasDisponibles(Controller $controlador, Container $container)
    {
        $em = $controlador->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Familia')
                 ->createQueryBuilder('f')
                 ->where('f.estaDisponible = 0');
        $familias = $qb->getQuery()
                       ->getResult();
        $fechaActual = new \DateTime();
        foreach($familias as $familia) {
            $sw = true;
            foreach($familia->getAlojamientos() as $alojamiento) {
                $fechaFinIntercambio = $alojamiento->getGrupo()->getIntercambio()->getFechaFin();//->format("d/m/Y");
                $sw = ($fechaFinIntercambio > $fechaActual) ? false : true;
            }
            if ($sw) {
                $familia->setEstaDisponible(true);
                $em->flush();
            }
        }
    }
}