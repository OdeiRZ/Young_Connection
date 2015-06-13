<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Familia;
use AppBundle\Form\Type\FamiliaType;
use AppBundle\Form\Type\FiltroPaisType;
use AppBundle\Utils\Aficiones;
use AppBundle\Utils\Mensajes;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function listarAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
                          $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $auxPaises = $em->createQueryBuilder('f')
                        ->select('f.pais')
                        ->from('AppBundle:Familia', 'f')
                        ->add('groupBy', 'f.pais')
                        ->orderBy('f.pais', 'ASC')
                        ->getQuery()
                        ->getResult();
        $paises = [];
        foreach ($auxPaises as $i => $pais) {
            $paises[$auxPaises[$i]['pais']] = $auxPaises[$i]['pais'];
        }
        $form = $this->createForm(new FiltroPaisType(), $paises, [
            'paises' => $paises,
            'familia' => true
        ])->handleRequest($peticion);
        $pais = ($form->isValid()) ? $_POST['filtroPaises']['pais'] : null;
        $qb = $em->getRepository('AppBundle:Familia')
                 ->createQueryBuilder('f');
        if ($pais) {
            $qb->where('f.pais = :pais')
               ->setParameter('pais', $_POST['filtroPaises']['pais']);
        }
        $familias = $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Familia:listar.html.twig', [
            'formulario_paises' => $form->createView(),
            'familias' => $familias
        ]);
    }

    /**
     * @Route("/modificar/{familia}", name="familia_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ALUMNO')")
     */
    public function modificarAction(Familia $familia, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$familia) {
            throw $this->createNotFoundException('No hay familias disponibles '.$familia);
        }
        $miembros = new ArrayCollection();
        foreach ($familia->getMiembros() as $miembro) {
            $miembros->add($miembro);
        }
        $alumnos = new ArrayCollection();
        foreach ($familia->getAlumnos() as $alumno) {
            $alumnos->add($alumno);
        }
        foreach ($familia->getAlumnos() as $alumno) {
            $alumno->setFamilia(null);
        }
        $formulario = $this->createForm(new FamiliaType(), $familia, ['usuario' => $this->get('security.token_storage')
                                                                                        ->getToken()->getUser()->getId()]);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Familia',
                'attr' => ['class' => 'btn btn-danger']
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            foreach ($miembros as $miembro) {
                if (false === $familia->getMiembros()->contains($miembro)) {
                    $em->remove($miembro); //$miembro->setFamilia(null);    //$familia->removeElement($miembro); //$em->persist($miembro);
                }
            }
            if ($formulario->get('eliminar')->isClicked()) {
                if (sizeof($familia->getAlojamientos())) {
                    $this->addFlash('error', 'No puedes eliminar una Familia con Alojamientos asignados');
                } else {
                    foreach ($alumnos as $alumno) {     //$usuario = $this->get('security.token_storage')->getToken()->getUser();
                        $alumno->setFamilia(null);
                    }
                    $em->remove($familia);
                }
            } else {
                $familia->addAlumno($this->get('security.token_storage')->getToken()->getUser());
                foreach ($familia->getAlumnos() as $alumno) {
                    $alumno->setFamilia($familia);
                }
                $this->addFlash('success', 'Datos guardados correctamente');
            }
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl('inicio')
            );
        }
        return $this->render('AppBundle:Familia:modificar.html.twig', [
            'familia' => $familia,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="familia_nuevo"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ALUMNO')")
     */
    public function nuevoAction(Request $peticion)
    {
        $familia = new Familia();
        $formulario = $this->createForm(new FamiliaType(), $familia, ['usuario' => $this->get('security.token_storage')
                                                                                        ->getToken()->getUser()->getId()]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $familia->addAlumno($this->get('security.token_storage')->getToken()->getUser());
            foreach ($familia->getAlumnos() as $alumno) {       //$usuario = $this->get('security.token_storage')->getToken()->getUser();
                $alumno->setFamilia($familia);                  //$usuario->setFamilia(null);
            }
            $em->persist($familia);
            $em->flush();
            $this->addFlash('success', 'Familia creada correctamente');
            return new RedirectResponse(
                $this->generateUrl('inicio')
            );
        }
        return $this->render('AppBundle:Familia:nuevo.html.twig', [
            'familia' => $familia,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{familia}", name="familia_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarAction(Familia $familia, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        if (sizeof($familia->getAlojamientos())) {
            $this->addFlash('error', 'No puedes eliminar una Familia con Alojamientos asignados');
        } else {
            foreach ($familia->getAlumnos() as $alumno) {
                $alumno->setFamilia(null);
            }
            $em->remove($familia);
            $em->flush();
        }
        return new RedirectResponse(
            $this->generateUrl($this->isGranted('ROLE_ADMIN') ? 'familias_listar' : 'inicio')
        );
    }

    /**
     * @Route("/eliminarGrupo", name="grupo_familia_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarGrupoAction(Request $peticion)
    {
        if (isset($_POST['grupoFamilias']) && sizeof($_POST['grupoFamilias'])) {
            $sw = false;
            $em = $this->getDoctrine()->getManager();
            $familias = new ArrayCollection();
            foreach($_POST['grupoFamilias'] as $familia) {
                $familias->add($em->getRepository('AppBundle:Familia')->findOneBy( array('id' => $familia)));
            }
            foreach($familias as $familia) {
                if (sizeof($familia->getAlojamientos())) {
                    $sw = true;
                } else {
                    foreach($familia->getAlumnos() as $alumno) {
                        $alumno->setFamilia(null);
                    }
                    $em->remove($familia);
                }
            }
            $this->addFlash(($sw) ? 'error' : 'success', ($sw) ? 'Alguna/s de los Familias no se han podido eliminar' : 'Familias eliminadas correctamente');
            $em->flush();
        } else {
            $this->addFlash('error', 'Debes seleccionar al menos una Familia');
        }
        return new RedirectResponse(
            $this->generateUrl('familias_listar')
        );
    }
}