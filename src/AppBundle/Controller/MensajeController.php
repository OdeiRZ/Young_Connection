<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mensaje;
use AppBundle\Form\Type\MensajeType;
use AppBundle\Form\Type\FiltroUsuarioType;
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
        Mensajes::actualizarMensajesNoLeidos($this, $this->container, $this->get('security.token_storage')->getToken()->getUser());
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this,
            $this->container, $this->get('security.token_storage')->getToken()->getUser()));
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new FiltroUsuarioType())->handleRequest($peticion);
        $usuario = ($form->isValid()) ? $_POST['filtroUsuarios']['usuario'] : null;
        $qb = $em->getRepository('AppBundle:Mensaje')
                 ->createQueryBuilder('m')
                 ->where('m.usuarioOrigen = :id')
                 ->setParameter('id', $this->get('security.token_storage')->getToken()->getUser())
                 ->addOrderBy('m.usuarioDestino', 'DESC')
                 ->addOrderBy('m.fechaEnvio', 'ASC');
        if ($usuario) {
            $qb->where('m.usuarioOrigen = :usuario')
                ->setParameter('usuario', $_POST['filtroUsuarios']['usuario']);
        }
        $mensajes = $qb
            ->getQuery()
            ->getResult();
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
        $formulario = $this->createForm(new MensajeType(), $mensaje);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Mensaje',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($formulario->get('eliminar')->isClicked()) {
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
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function eliminarAction(Mensaje $mensaje, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($mensaje);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('mensajes_listar')
        );
    }
}
