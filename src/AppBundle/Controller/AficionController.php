<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aficion;
use AppBundle\Form\Type\AficionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/aficion")
 */
class AficionController extends Controller
{
    /**
     * @Route("/listar", name="aficiones_listar")
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $aficiones = $em->getRepository('AppBundle:Aficion')
            ->createQueryBuilder('a')
            ->orderBy('a.descripcion')
            //->where('a.validada = true')
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Aficion:listar.html.twig', [
            'aficiones' => $aficiones
        ]);
    }

    /**
     * @Route("/modificar/{aficion}", name="aficion_modificar"), methods={'GET', 'POST'}
     */
    public function modificarAction(Aficion $aficion, Request $peticion)
    {
        $formulario = $this->createForm(new AficionType(), $aficion);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Afición',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($aficion);
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
            return new RedirectResponse(
                $this->generateUrl('aficiones_listar')
            );
        }
        return $this->render('AppBundle:Aficion:modificar.html.twig', [
            'aficion' => $aficion,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="aficion_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $aficion = new Aficion();
        $aficion
            ->setValidada(false);
        $formulario = $this->createForm(new AficionType(), $aficion, [
            'admin' => $this->isGranted('ROLE_ADMIN'),
        ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aficion);
            $em->flush();
            $this->addFlash('success', $this->isGranted('ROLE_ADMIN') ? 'Afición creada correctamente' : 'Afición creada, no podrá seleccionarla hasta que sea validada');
            return new RedirectResponse(
                $this->generateUrl('aficiones_listar')
            );
        }
        return $this->render('AppBundle:Aficion:nuevo.html.twig', [
            'aficion' => $aficion,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{aficion}", name="aficion_eliminar"), methods={'GET', 'POST'}
     */
    public function eliminarAction(Aficion $aficion, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($aficion);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('aficiones_listar')
        );
    }
}
