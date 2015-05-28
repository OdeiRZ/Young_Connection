<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Alumno;
use AppBundle\Entity\Idioma;
use AppBundle\Form\Type\AlumnoType;
use AppBundle\Form\Type\FiltroCursoType;
use AppBundle\Utils\Mensajes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/alumno")
 */
class AlumnoController extends Controller
{
    /**
     * @Route("/listar", name="alumnos_listar")
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function listarAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this,
            $this->container, $this->get('security.token_storage')->getToken()->getUser()));
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new FiltroCursoType())->handleRequest($peticion);
        $curso = ($form->isValid()) ? $_POST['filtroCursos']['curso'] : null;
        $qb = $em->getRepository('AppBundle:Alumno')
                 ->createQueryBuilder('a')
                 ->orderBy('a.usuario');
        if ($curso) {
            $qb->where('a.curso = :curso')
                ->setParameter('curso', $_POST['filtroCursos']['curso']);
        }
        $alumnos = $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Alumno:listar.html.twig', [
            'formulario_cursos' => $form->createView(),
            'alumnos' => $alumnos
        ]);
    }

    /**
     * @Route("/modificar/{alumno}", name="alumno_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function modificarAction(Alumno $alumno, Request $peticion)
    {
        $formulario = $this->createForm(new AlumnoType(), $alumno);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Alumno',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($alumno);
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
            return new RedirectResponse(
                $this->generateUrl('alumnos_listar')
            );
        }
        return $this->render('AppBundle:Alumno:modificar.html.twig', [
            'alumno' => $alumno,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="alumno_nuevo"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function nuevoAction(Request $peticion)
    {
        $alumno = new Alumno();
        $formulario = $this->createForm(new AlumnoType(), $alumno);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($alumno);
            $em->flush();
            $this->addFlash('success', 'Alumno creado correctamente');
            return new RedirectResponse(
                $this->generateUrl('alumnos_listar')
            );
        }
        return $this->render('AppBundle:Alumno:nuevo.html.twig', [
            'alumno' => $alumno,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{alumno}", name="alumno_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarAction(Alumno $alumno, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($alumno);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('alumnos_listar')
        );
    }
}
