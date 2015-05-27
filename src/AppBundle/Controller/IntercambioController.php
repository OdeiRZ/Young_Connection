<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intercambio;
use AppBundle\Form\Type\IntercambioType;
use AppBundle\Form\Type\FiltroFechasType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/intercambio")
 */
class IntercambioController extends Controller
{
    /**
     * @Route("/listar", name="intercambios_listar")
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function listarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fechasPorDefecto = array('desde' => null, 'hasta' => null);
        $form = $this->createForm(new FiltroFechasType(), $fechasPorDefecto)->handleRequest($request);
        $fechas = ($form->isValid()) ? ['desde' => $_POST['filtroFechas']['desde'], 'hasta' => $_POST['filtroFechas']['hasta']] : $fechasPorDefecto;
        $qb = $em->getRepository('AppBundle:Intercambio')
                 ->createQueryBuilder('i')
                 ->orderBy('i.fechaInicio', 'DESC');
        if ($fechas['desde'] && $fechas['hasta']) {
            $qb->where('i.fechaInicio >= :desde')
               ->andWhere('i.fechaFin <= :hasta')
               ->setParameter('desde', $fechas['desde'])
               ->setParameter('hasta', $fechas['hasta']);
        }
        $intercambios =  $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Intercambio:listar.html.twig', [
            'formulario_fechas' => $form->createView(),
            'intercambios' => $intercambios
        ]);
    }

    /**
     * @Route("/modificar/{intercambio}", name="intercambio_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function modificarAction(Intercambio $intercambio, Request $peticion)
    {
        $formulario = $this->createForm(new IntercambioType(), $intercambio);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Intercambio',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($intercambio);
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
            return new RedirectResponse(
                $this->generateUrl('intercambios_listar')
            );
        }
        return $this->render('AppBundle:Intercambio:modificar.html.twig', [
            'intercambio' => $intercambio,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="intercambio_nuevo"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function nuevoAction(Request $peticion)
    {
        $intercambio = new Intercambio();
        $formulario = $this->createForm(new IntercambioType(), $intercambio);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intercambio);
            $em->flush();
            $this->addFlash('success', 'Intercambio creado correctamente');
            return new RedirectResponse(
                $this->generateUrl('intercambios_listar')
            );
        }
        return $this->render('AppBundle:Intercambio:nuevo.html.twig', [
            'intercambio' => $intercambio,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{intercambio}", name="intercambio_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function eliminarAction(Intercambio $intercambio, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($intercambio);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('intercambios_listar')
        );
    }
}
