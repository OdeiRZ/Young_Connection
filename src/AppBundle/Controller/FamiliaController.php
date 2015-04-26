<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Familia;
use AppBundle\Entity\Miembro;
use AppBundle\Form\Type\FamiliaType;
use AppBundle\Form\Type\MiembroType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/familia")
 */
class FamiliaController extends Controller
{
    /**
     * @Route("/listar", name="familias_listar")
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $familias = $em->getRepository('AppBundle:Familia')
            ->createQueryBuilder('f')
            //->orderBy('f.alumno.usuario.apellidos', 'DESC')
            //->addOrderBy('f.alumno.usuario.nombre', 'DESC')
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Familia:listar.html.twig', [
            'familias' => $familias
        ]);
    }

    /**
     * @Route("/modificar/{familia}", name="familia_modificar"), methods={'GET', 'POST'}
     */
    public function modificarAction(Familia $familia, Request $peticion)
    {
        $formulario = $this->createForm(new FamiliaType(), $familia);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Familia',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($familia);
            }

            $em->flush();

            return new RedirectResponse(
                $this->generateUrl('familias_listar')
            );
        }
        return $this->render('AppBundle:Familia:modificar.html.twig', [
            'familia' => $familia,
            'formulario' => $formulario->createView()
        ]);
    }


    /**
     * @Route("/nuevo", name="familia_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $familia = new Familia();
        $formulario = $this->createForm(new FamiliaType(), $familia);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($familia);
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl('familias_listar')
            );
        }
        return $this->render('AppBundle:Familia:nuevo.html.twig', [
            'familia' => $familia,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/miembros", name="miembros_listar")
     */
    public function listarMiembrosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $miembros = $em->getRepository('AppBundle:Miembro')
            ->findAll();
           /* ->createQueryBuilder('m')
            ->orderBy('m.apellidos', 'DESC')
            ->addOrderBy('m.nombre', 'DESC')
            ->getQuery()
            ->getResult();*/
        return $this->render('AppBundle:Familia:listar_miembros.html.twig', [
            'miembros' => $miembros
        ]);
    }

    /**
     * @Route("/miembros/{miembro}", name="miembro_modificar"), methods={'GET', 'POST'}
     */
    public function modificarMiembroAction(Miembro $miembro, Request $peticion)
    {
        $formulario = $this->createForm(new MiembroType(), $miembro);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Miembro',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($miembro);
            }

            $em->flush();

            return new RedirectResponse(
                $this->generateUrl('miembros_listar')
            );
        }
        return $this->render('AppBundle:Familia:modificar_miembro.html.twig', [
            'miembro' => $miembro,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/miembros/nuevo", name="miembro_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoMiembroAction(Request $peticion)
    {
        $miembro = new Miembro();
        $formulario = $this->createForm(new MiembroType(), $miembro);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($miembro);
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl('miembros_listar')
            );
        }
        return $this->render('AppBundle:Familia:nuevo_miembro.html.twig', [
            'miembro' => $miembro,
            'formulario' => $formulario->createView()
        ]);
    }
}
