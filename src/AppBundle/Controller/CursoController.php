<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Curso;
use AppBundle\Form\Type\CursoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/curso")
 */
class CursoController extends Controller
{
    /**
     * @Route("/listar", name="cursos_listar")
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cursos = $em->getRepository('AppBundle:Curso')
            ->createQueryBuilder('c')
            ->orderBy('c.descripcion', 'DESC')
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Curso:listar.html.twig', [
            'cursos' => $cursos
        ]);
    }

    /**
     * @Route("/modificar/{curso}", name="curso_modificar"), methods={'GET', 'POST'}
     */
    public function modificarAction(Curso $curso, Request $peticion)
    {
        $formulario = $this->createForm(new CursoType(), $curso);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Curso',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($curso);
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
            return new RedirectResponse(
                $this->generateUrl('cursos_listar')
            );
        }
        return $this->render('AppBundle:Curso:modificar.html.twig', [
            'curso' => $curso,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="curso_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $curso = new Curso();
        $formulario = $this->createForm(new CursoType(), $curso);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($curso);
            $em->flush();
            $this->addFlash('success', 'Curso creado correctamente');
            return new RedirectResponse(
                $this->generateUrl('cursos_listar')
            );
        }
        return $this->render('AppBundle:Curso:nuevo.html.twig', [
            'curso' => $curso,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{curso}", name="curso_eliminar"), methods={'GET', 'POST'}
     */
    public function eliminarAction(Curso $curso, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($curso);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('cursos_listar')
        );
    }
}
