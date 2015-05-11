<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intercambio;
use AppBundle\Form\Type\IntercambioType;
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
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $intercambios = $em->getRepository('AppBundle:Intercambio')
            ->createQueryBuilder('i')
            ->orderBy('i.fechaInicio', 'DESC')
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Intercambio:listar.html.twig', [
            'intercambios' => $intercambios
        ]);
    }

    /**
     * @Route("/modificar/{intercambio}", name="intercambio_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     * @Security(expression="has_role('ROLE_COORDINADOR')")
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
     * @Security(expression="has_role('ROLE_ADMIN')")
     * @Security(expression="has_role('ROLE_COORDINADOR')")
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
     * @Security(expression="has_role('ROLE_ADMIN')")
     * @Security(expression="has_role('ROLE_COORDINADOR')")
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
