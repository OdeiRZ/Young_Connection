<?php

namespace AppBundle\Utils;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;

class Intercambios extends Controller
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
                $fechaFinIntercambio = $alojamiento->getGrupo()->getIntercambio()->getFechaFin();
                if ($fechaFinIntercambio > $fechaActual) {
                    $sw = false;
                    break;
                }
            }
            if ($sw) {
                $familia->setEstaDisponible(true);
                $em->flush();
            }
        }
    }

    static public function actualizarAlumnosDisponibles(Controller $controlador, Container $container)
    {
        $em = $controlador->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Usuario')
            ->createQueryBuilder('a')
            ->Where('a.esAlumno = 1')
            ->andWhere('a.esActivo = 1')
            ->andWhere('a.estaDisponible = 0');
        $alumnos = $qb->getQuery()
            ->getResult();
        $fechaActual = new \DateTime();
        foreach($alumnos as $alumno) {
            $sw = true;
            foreach($alumno->getAlojamientos() as $alojamiento) {
                $fechaFinIntercambio = $alojamiento->getGrupo()->getIntercambio()->getFechaFin();
                if ($fechaFinIntercambio > $fechaActual) {
                    $sw = false;
                    break;
                }
            }
            if ($sw) {
                $alumno->setEstaDisponible(true);
                $em->flush();
            }
        }
    }
}