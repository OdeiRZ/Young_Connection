<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Grupo;
use AppBundle\Form\Type\GrupoType;
use AppBundle\Form\Type\FiltroCursoType;
use AppBundle\Utils\Aficiones;
use AppBundle\Utils\Mensajes;
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
        $form = $this->createForm(new FiltroCursoType())->handleRequest($peticion);
        $curso = ($form->isValid()) ? $_POST['filtroCursos']['curso'] : null;
        $qb = $em->getRepository('AppBundle:Grupo')
                 ->createQueryBuilder('g');
                 //->orderBy('i.fechaInicio', 'DESC');
        if ($curso) {
            //$qb->where('a.curso = :curso')
                //->setParameter('curso', $_POST['filtroCursos']['curso']);
        }
        $grupos = $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Grupo:listar.html.twig', [
            'formulario_cursos' => $form->createView(),
            'grupos' => $grupos
        ]);
    }

    /**
     * @Route("/modificar/{grupo}", name="grupo_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function modificarAction(Grupo $grupo, Request $peticion)
    {
        $formulario = $this->createForm(new GrupoType(), $grupo);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Grupo',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($grupo);
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
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
        $em = $this->getDoctrine()->getManager();
        $em->remove($grupo);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('grupos_listar')
        );
    }
}
