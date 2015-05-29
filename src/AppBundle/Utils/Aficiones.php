<?php

namespace AppBundle\Utils;

use AppBundle\Controller\DefaultController;
use AppBundle\Entity\Aficion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class Aficiones extends Controller
{
    static public function obtenerAficionesNoValidadas(Controller $controlador, Container $container)
    {
        $em = $controlador->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Aficion')
                 ->createQueryBuilder('a')
                 ->select('COUNT(a)')
                 ->where('a.validada = 0');
        $aficiones = $qb->getQuery()->getSingleScalarResult();
        return $aficiones;
    }
}