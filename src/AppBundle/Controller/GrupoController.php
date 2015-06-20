<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Grupo;
use AppBundle\Form\Type\GrupoType;
use AppBundle\Form\Type\FiltroCoordinadorType;
use AppBundle\Utils\Aficiones;
use AppBundle\Utils\Intercambios;
use AppBundle\Utils\Mensajes;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/grupo")
 */
class GrupoController extends Controller
{
    /**
     * @Route("/listar", name="grupos_listar")
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function listarAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
                          $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new FiltroCoordinadorType())->handleRequest($peticion);
        $curso = ($form->isValid()) ? $_POST['filtroCoordinadores']['coordinador'] : null;
        $qb = $em->getRepository('AppBundle:Grupo')
                 ->createQueryBuilder('g')
                 ->orderBy('g.descripcion', 'ASC');
        if ($curso) {
            $qb->where('g.coordinador = :coordinador')
               ->setParameter('coordinador', $_POST['filtroCoordinadores']['coordinador']);
        }
        $grupos = $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Grupo:listar.html.twig', [
            'formulario_coordinadores' => $form->createView(),
            'grupos' => $grupos
        ]);
    }

    /**
     * @Route("/modificar/{grupo}", name="grupo_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function modificarAction(Grupo $grupo, Request $peticion)
    {
        $usuarioActivo = $this->getUser();
        if ($grupo->getCoordinador()->getId() !== $usuarioActivo->getId() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->createAccessDeniedException();
        }
        Intercambios::actualizarFamiliasDisponibles($this, $this->container);
        Intercambios::actualizarAlumnosDisponibles($this, $this->container);
        $formulario = $this->createForm(new GrupoType(), $grupo);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Grupo',
                'attr' => [ 'class' => 'btn borrar cbutton cbutton--effect-novak-borrar' ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $this->addFlash('success', 'Grupo eliminado correctamente');
                $em->remove($grupo);
            } else {
                $this->addFlash('success', 'Datos guardados correctamente');
            }
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl('grupos_listar')
            );
        }
        return $this->render('AppBundle:Grupo:modificar.html.twig', [
            'grupo' => $grupo,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="grupo_nuevo"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function nuevoAction(Request $peticion)
    {
        Intercambios::actualizarFamiliasDisponibles($this, $this->container);
        Intercambios::actualizarAlumnosDisponibles($this, $this->container);
        $grupo = new Grupo();
        $formulario = $this->createForm(new GrupoType(), $grupo);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($grupo);
            $em->flush();
            $this->addFlash('success', 'Grupo creado correctamente');
            return new RedirectResponse(
                $this->generateUrl('grupos_listar')
            );
        }
        return $this->render('AppBundle:Grupo:nuevo.html.twig', [
            'grupo' => $grupo,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{grupo}", name="grupo_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function eliminarAction(Grupo $grupo, Request $peticion)
    {
        $usuarioActivo = $this->getUser();
        if ($grupo->getCoordinador()->getId() !== $usuarioActivo->getId() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $this->addFlash('success', 'Grupo eliminado correctamente');
        $em->remove($grupo);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('grupos_listar')
        );
    }

    /**
     * @Route("/eliminarGrupo", name="grupo_grupo_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarGrupoAction(Request $peticion)
    {
        if (isset($_POST['grupoGrupos']) && sizeof($_POST['grupoGrupos'])) {
            $em = $this->getDoctrine()->getManager();
            $grupos = new ArrayCollection();
            foreach($_POST['grupoGrupos'] as $grupo) {
                $grupos->add($em->getRepository('AppBundle:Grupo')->findOneBy( array('id' => $grupo)));
            }
            foreach($grupos as $grupo) {
                $em->remove($grupo);
            }
            $this->addFlash('success', 'Grupos eliminados correctamente');
            $em->flush();
        } else {
            $this->addFlash('error', 'Debes seleccionar al menos un Grupo');
        }
        return new RedirectResponse(
            $this->generateUrl('grupos_listar')
        );
    }
}