<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intercambio;
use AppBundle\Form\Type\IntercambioType;
use AppBundle\Form\Type\FiltroFechasType;
use AppBundle\Utils\Aficiones;
use AppBundle\Utils\Mensajes;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/intercambio")
 */
class IntercambioController extends BaseController
{
    /**
     * @Route("/listar", name="intercambios_listar")
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function listarAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
                          $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $fechasPorDefecto = array('desde' => null, 'hasta' => null);
        $form = $this->createForm(new FiltroFechasType(), $fechasPorDefecto)->handleRequest($peticion);
        $fechas = ($form->isValid()) ? ['desde' => $_POST['filtroFechas']['desde'], 'hasta' => $_POST['filtroFechas']['hasta']] : $fechasPorDefecto;
        $qb = $em->getRepository('AppBundle:Intercambio')
                 ->createQueryBuilder('i')
                 ->orderBy('i.fechaInicio', 'DESC');
        if ($fechas['desde'] && $fechas['hasta']) {
            if(new \DateTime($fechas['desde']) <= new \DateTime($fechas['hasta'])) {
                 $qb->where('i.fechaInicio >= :desde')
                    ->andWhere('i.fechaFin <= :hasta')
                    ->setParameter('desde', $fechas['desde'])
                    ->setParameter('hasta', $fechas['hasta']);
            } else {
                $this->addFlash('error', 'La Fecha de Inicio debe ser inferior a la Fecha Final');
            }
        }
        $intercambios = $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Intercambio:listar.html.twig', [
            'formulario_fechas' => $form->createView(),
            'intercambios' => $intercambios
        ]);
    }

    /**
     * @Route("/modificar/{intercambio}", name="intercambio_modificar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function modificarAction(Intercambio $intercambio, Request $peticion)
    {
        $sw = false;
        $usuarioActivo = $this->getUser();
        foreach($intercambio->getGrupos() as $grupo) {
            if ($grupo->getCoordinador()->getId() == $usuarioActivo->getId()) {
                $sw = true;
                break;
            }
        }
        if (!$sw && !$this->isGranted('ROLE_ADMIN')) {
            return $this->createAccessDeniedException();
        }
        $formulario = $this->createForm(new IntercambioType(), $intercambio);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Intercambio',
                'attr' => [ 'class' => 'btn borrar cbutton cbutton--effect-novak-borrar' ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach($intercambio->getGrupos() as $grupo) {
                $grupo->setIntercambio(null);
            }
            if ($formulario->get('eliminar')->isClicked()) {
                $this->addFlash('success', 'Intercambio eliminado correctamente');
                $em->remove($intercambio);
            } else {
                foreach($intercambio->getGrupos() as $grupo) {
                    $grupo->setIntercambio($intercambio);
                }
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
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
     * @Route("/imprimir/{intercambio}", name="intercambio_imprimir"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function imprimirAction(Intercambio $intercambio, Request $peticion)
    {
        $plantilla = $this->container->getParameter('intercambio');
        $logos = $this->container->getParameter('logos');
        $pdf = $this->generarPdf('Intercambio #' . $intercambio->getId(), $logos, $plantilla, 0, 'I' . $intercambio->getId());
        $html = $this->renderView('AppBundle:Intercambio:imprimir.html.twig',
            array(
                'intercambio' => $intercambio,
                'localidad' => $this->container->getParameter('localidad')
            ));
        $pdf->writeHTML($html);
        return new RedirectResponse(
            $pdf->Output("Intercambio_" . $intercambio->getId() .".pdf", 'D')
        );
    }

    /**
     * @Route("/nuevo", name="intercambio_nuevo"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function nuevoAction(Request $peticion)
    {
        $ruta = 'intercambios_listar';
        $intercambio = new Intercambio();
        $formulario = $this->createForm(new IntercambioType(), $intercambio);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            if($intercambio->getFechaInicio() <= $intercambio->getFechaFin()) {
                $em = $this->getDoctrine()->getManager();
                foreach($intercambio->getGrupos() as $grupo) {
                    $grupo->setIntercambio($intercambio);
                    foreach($grupo->getAlojamientos() as $alojamiento) {
                        $alojamiento->getFamilia()->setEstaDisponible(false);
                        $alojamiento->getAlumno()->setEstaDisponible(false);
                        if ($alojamiento->getFamilia()->getPais() != $alojamiento->getAlumno()->getPais()) {
                            $alojamiento->getAlumno()->setHaViajadoExtranjero(true);
                        }
                    }
                }
                $em->persist($intercambio);
                $em->flush();
                $this->addFlash('success', 'Intercambio creado correctamente');
                $this->notificarIntercambio($intercambio->getGrupos(), $intercambio);
            } else {
                $ruta = 'intercambio_nuevo';
                $this->addFlash('error', 'La Fecha de Inicio debe ser inferior a la Fecha Final');
            }
            return new RedirectResponse(
                $this->generateUrl($ruta)
            );
        }
        return $this->render('AppBundle:Intercambio:nuevo.html.twig', [
            'intercambio' => $intercambio,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{intercambio}", name="intercambio_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function eliminarAction(Intercambio $intercambio, Request $peticion)
    {
        $sw = false;
        $usuarioActivo = $this->getUser();
        foreach($intercambio->getGrupos() as $grupo) {
            if ($grupo->getCoordinador()->getId() == $usuarioActivo->getId()) {
                $sw = true;
                break;
            }
        }
        if (!$sw && !$this->isGranted('ROLE_ADMIN')) {
            return $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        foreach($intercambio->getGrupos() as $grupo) {
            $grupo->setIntercambio(null);
            foreach($grupo->getAlojamientos() as $alojamiento) {
                $alojamiento->getFamilia()->setEstaDisponible(true);
                $alojamiento->getAlumno()->setEstaDisponible(true);
            }
        }
        $this->addFlash('success', 'Intercambio eliminado correctamente');
        $em->remove($intercambio);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('intercambios_listar')
        );
    }

    /**
     * @Route("/eliminarGrupo", name="grupo_intercambio_eliminar"), methods={'GET', 'POST'}
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarGrupoAction(Request $peticion)
    {
        if (isset($_POST['grupoIntercambios']) && sizeof($_POST['grupoIntercambios'])) {
            $em = $this->getDoctrine()->getManager();
            $intercambios = new ArrayCollection();
            foreach($_POST['grupoIntercambios'] as $intercambio) {
                $intercambios->add($em->getRepository('AppBundle:Intercambio')->findOneBy( array('id' => $intercambio)));
            }
            foreach($intercambios as $intercambio) {
                foreach($intercambio->getGrupos() as $grupo) {
                    $grupo->setIntercambio(null);
                    foreach($grupo->getAlojamientos() as $alojamiento) {
                        $alojamiento->getFamilia()->setEstaDisponible(true);
                        $alojamiento->getAlumno()->setEstaDisponible(true);
                    }
                }
                $em->remove($intercambio);
            }
            $this->addFlash('success', 'Intercambios eliminados correctamente');
            $em->flush();
        } else {
            $this->addFlash('error', 'Debes seleccionar al menos un Intercambio');
        }
        return new RedirectResponse(
            $this->generateUrl('intercambios_listar')
        );
    }
}