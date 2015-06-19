<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mensaje;
use AppBundle\Form\Type\MensajeType;
use AppBundle\Form\Type\FiltroUsuarioType;
use AppBundle\Utils\Aficiones;
use AppBundle\Utils\Mensajes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/mensaje")
 */
class MensajeController extends Controller
{
    /**
     * @Route("/listar", name="mensajes_listar")
     */
    public function listarAction(Request $peticion)
    {
        $miUsuario = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
                          $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new FiltroUsuarioType())->handleRequest($peticion);
        $mensajes = null;
        $usuario = ($form->isValid()) ? $_POST['filtroUsuarios']['usuario'] : null;
        if ($usuario) {
            $qb = $em->getRepository('AppBundle:Mensaje')
                     ->createQueryBuilder('m')
                     ->where('m.usuarioDestino = :id AND m.usuarioOrigen = :usuario OR m.usuarioDestino = :usuario AND m.usuarioOrigen = :id')
                     ->addOrderBy('m.fechaEnvio', 'DESC')
                     ->setParameter('id', $miUsuario)
                     ->setParameter('usuario', $usuario);
            $mensajes = $qb
                ->getQuery()
                ->getResult();
        } else {
            $qb = $em->getRepository('AppBundle:Mensaje')
                     ->createQueryBuilder('m')
                     ->where('m.usuarioDestino = :id')
                     ->andWhere('m.estaRecibido = false')
                     ->addOrderBy('m.fechaEnvio', 'ASC')
                     ->addOrderBy('m.usuarioDestino', 'DESC')
                     ->setParameter('id', $miUsuario);
            $mensajes = $qb
                ->getQuery()
                ->getResult();
        }
        Mensajes::actualizarMensajesNoLeidos($this, $this->container, $this->get('security.token_storage')->getToken()->getUser());
        return $this->render('AppBundle:Mensaje:listar.html.twig', [
            'formulario_usuarios' => $form->createView(),
            'mensajes' => $mensajes
        ]);
    }

    /**
     * @Route("/modificar/{mensaje}", name="mensaje_modificar"), methods={'GET', 'POST'}
     */
    public function modificarAction(Mensaje $mensaje, Request $peticion)
    {
        $usuarioActivo = $this->getUser();
        if ($mensaje->getUsuarioDestino()->getId() !== $usuarioActivo->getId() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->createAccessDeniedException();
        }
        $formulario = $this->createForm(new MensajeType(), $mensaje);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Mensaje',
                'attr' => [ 'class' => 'btn borrar cbutton cbutton--effect-novak-borrar' ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
                $this->addFlash('success', 'Mensaje eliminado correctamente');
                $em->remove($mensaje);
            }
            $em->flush();
            $this->addFlash('success', 'Datos guardados correctamente');
            return new RedirectResponse(
                $this->generateUrl('mensajes_listar')
            );
        }
        return $this->render('AppBundle:Mensaje:modificar.html.twig', [
            'mensaje' => $mensaje,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="mensaje_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $mensaje = new Mensaje();
        $mensaje->setFechaEnvio(new \DateTime())
                ->setEstaRecibido(false)
                ->setUsuarioOrigen($this->get('security.token_storage')->getToken()->getUser());
        $formulario = $this->createForm(new MensajeType(), $mensaje);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mensaje);
            $em->flush();
            $this->addFlash('success', 'Mensaje creado correctamente');
            return new RedirectResponse(
                $this->generateUrl('mensajes_listar')
            );
        }
        return $this->render('AppBundle:Mensaje:nuevo.html.twig', [
            'mensaje' => $mensaje,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{mensaje}", name="mensaje_eliminar"), methods={'GET', 'POST'}
     */
    public function eliminarAction(Mensaje $mensaje, Request $peticion)
    {
        $usuarioActivo = $this->getUser();
        if ($mensaje->getUsuarioDestino()->getId() !== $usuarioActivo->getId() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $this->addFlash('success', 'Mensaje eliminado correctamente');
        $em->remove($mensaje);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('mensajes_listar')
        );
    }
}
