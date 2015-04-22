<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mensaje;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\MensajeType;
use AppBundle\Form\Type\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $mensajes = $em->getRepository('AppBundle:Mensaje')
            ->createQueryBuilder('m')
            ->orderBy('m.fechaEnvio', 'DESC')
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Mensaje:listar.html.twig', [
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
        //$em = $this->getDoctrine()->getManager();
        //$usuario = $em->getRepository('Usuario')->findOneById(1);
        $mensaje = new Mensaje();
        $mensaje->setFechaEnvio(new \DateTime());
                //->setUsuarioOrigen($usuario);
        $formulario = $this->createForm(new MensajeType(), $mensaje);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mensaje);
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl('mensajes_listar')
            );
        }
        return $this->render('AppBundle:Mensaje:nuevo.html.twig', [
            'mensaje' => $mensaje,
            'formulario' => $formulario->createView()
        ]);
    }
}
