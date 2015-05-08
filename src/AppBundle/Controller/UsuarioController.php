<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/listar", name="usuarios_listar")
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')
            ->createQueryBuilder('n')
            ->orderBy('n.apellidos', 'DESC')
            ->addOrderBy('n.nombre', 'DESC')
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Usuario:listar.html.twig', [
            'usuarios' => $usuarios
        ]);
    }

    /**
     * @Route("/modificar/{usuario}", name="usuario_modificar"), methods={'GET', 'POST'}
     */
    public function modificarAction(Usuario $usuario, Request $peticion)
    {
        $formulario = $this->createForm(new UsuarioType(), $usuario);
        $formulario
            ->add('eliminar', 'submit', [
                'label' => 'Eliminar Usuario',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $helper =  $password = $this->container->get('security.password_encoder');
            $usuario->setPassword($helper->encodePassword($usuario, $usuario->getPassword()));
            if ($formulario->get('eliminar')->isClicked()) {
                $em->remove($usuario);
            }
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl('usuarios_listar')
            );
        }
        return $this->render('AppBundle:Usuario:modificar.html.twig', [
            'usuario' => $usuario,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="usuario_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $usuario = new Usuario();
        $formulario = $this->createForm(new UsuarioType(), $usuario);
        $formulario->handleRequest($peticion);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $helper =  $password = $this->container->get('security.password_encoder');
            $usuario->setPassword($helper->encodePassword($usuario, $usuario->getPassword()));
            $em->persist($usuario);
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl('usuarios_listar')
            );
        }
        return $this->render('AppBundle:Usuario:nuevo.html.twig', [
            'usuario' => $usuario,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{usuario}", name="usuario_eliminar"), methods={'GET', 'POST'}
     */
    public function eliminarAction(Usuario $usuario, Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($usuario);
        $em->flush();
        return new RedirectResponse(
            $this->generateUrl('usuarios_listar')
        );
    }
}
