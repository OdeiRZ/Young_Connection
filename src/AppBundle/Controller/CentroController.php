<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Centro;
use AppBundle\Form\Type\CentroType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/centro")
 */
class CentroController extends Controller
{
    /**
     * @Route("/listar", name="centros_listar")
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $centros = $em->getRepository('AppBundle:Centro')
            ->createQueryBuilder('c')
            ->orderBy('c.nombre', 'DESC')
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Centro:listar.html.twig', [
            'centros' => $centros
        ]);
    }

    /**
     * @Route("/modificar/{centro}", name="centro_modificar"), methods={'GET', 'POST'}
     */
    public function modificarAction(Centro $centro, Request $peticion)
    {
        $formulario = $this->createForm(new CentroType(), $centro);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Centro',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($centro);
            }

            $em->flush();

            return new RedirectResponse(
                $this->generateUrl('centros_listar')
            );
        }
        return $this->render('AppBundle:Centro:modificar.html.twig', [
            'centro' => $centro,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="centro_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $centro = new Centro();
        $formulario = $this->createForm(new CentroType(), $centro);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($centro);
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl('centros_listar')
            );
        }
        return $this->render('AppBundle:Centro:nuevo.html.twig', [
            'centro' => $centro,
            'formulario' => $formulario->createView()
        ]);
    }
}
