<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Curso;
use AppBundle\Form\Type\CursoType;
use AppBundle\Form\Type\FiltroFamiliaType;
use AppBundle\Utils\Aficiones;
use AppBundle\Utils\Mensajes;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
    public function listarAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
                          $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $auxFamilias = $em->createQueryBuilder('c')
                          ->select('c.familia')
                          ->from('AppBundle:Curso', 'c')
                          ->add('groupBy', 'c.familia')
                          ->orderBy('c.familia', 'ASC')
                          ->getQuery()
                          ->getResult();
        $familias = [];
        foreach ($auxFamilias as $i => $familia) {
            $familias[$auxFamilias[$i]['familia']] = $auxFamilias[$i]['familia'];
        }
        $form = $this->createForm(new FiltroFamiliaType(), $familias, [ 'familias' => $familias ])->handleRequest($peticion);
        $familia = ($form->isValid()) ? $_POST['filtroFamilias']['familia'] : null;
        $qb = $em->getRepository('AppBundle:Curso')
                 ->createQueryBuilder('c')
                 ->orderBy('c.centro', 'DESC')
                 ->AddOrderBy('c.familia', 'ASC')
                 ->AddOrderBy('c.descripcion', 'ASC');
        if ($familia) {
            $qb->where('c.familia = :familia')
               ->setParameter('familia', $_POST['filtroFamilias']['familia']);
        }
        $cursos = $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Curso:listar.html.twig', [
            'formulario_familias' => $form->createView(),
            'cursos' => $cursos
        ]);
    }

    /**
     * @Route("/modificar/{curso}", name="curso_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function modificarAction(Curso $curso, Request $peticion)
    {
        $formulario = $this->createForm(new CursoType(), $curso);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Curso',
                'attr' => [ 'class' => 'btn borrar cbutton cbutton--effect-novak-borrar' ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                if (sizeof($curso->getAlumnos())) {
                    $this->addFlash('error', 'No puedes eliminar un Curso con Usuarios asignados');
                } else {
                    $this->addFlash('success', 'Curso eliminado correctamente');
                    $em->remove($curso);
                    $em->flush();
                }
            } else {
                $this->addFlash('success', 'Datos guardados correctamente');
            }
            $em->flush();
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
     * @Security(expression="has_role('ROLE_ADMIN')")
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
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarAction(Curso $curso, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        if (sizeof($curso->getAlumnos())) {
            $this->addFlash('error', 'No puedes eliminar un Curso con Usuarios asignados');
        } else {
            $this->addFlash('success', 'Curso eliminado correctamente');
            $em->remove($curso);
            $em->flush();
        }
        return new RedirectResponse(
            $this->generateUrl('cursos_listar')
        );
    }

    /**
     * @Route("/eliminarGrupo", name="grupo_curso_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarGrupoAction(Request $peticion)
    {
        if (isset($_POST['grupoCursos']) && sizeof($_POST['grupoCursos'])) {
            $sw = false;
            $em = $this->getDoctrine()->getManager();
            $cursos = new ArrayCollection();
            foreach($_POST['grupoCursos'] as $curso) {
                $cursos->add($em->getRepository('AppBundle:Curso')->findOneBy( array('id' => $curso)));
            }
            foreach($cursos as $curso) {
                if (sizeof($curso->getAlumnos())) {
                    $sw = true;
                } else {
                    $em->remove($curso);
                }
            }
            $this->addFlash(($sw) ? 'error' : 'success', ($sw) ? 'Alguno/s de los Cursos no se han podido eliminar' : 'Cursos eliminados correctamente');
            $em->flush();
        } else {
            $this->addFlash('error', 'Debes seleccionar al menos un Curso');
        }
        return new RedirectResponse(
            $this->generateUrl('cursos_listar')
        );
    }
}
