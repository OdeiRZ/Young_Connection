<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\UsuarioType;
use AppBundle\Utils\Notificaciones;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/listar", name="usuarios_listar")
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function listarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')
            ->createQueryBuilder('u')
            ->orderBy('uapellidos', 'DESC')
            ->addOrderBy('u.nombre', 'DESC')
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
        $usuarioActivo = $this->getUser();
        if ($usuario->getId() !== $usuarioActivo->getId() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->createAccessDeniedException();
        }
        $formulario = $this->createForm(new UsuarioType(), $usuario, [
            'admin' => $this->isGranted('ROLE_ADMIN'),
            'coordinador' => $this->isGranted('ROLE_COORDINADOR')
        ]);
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $helper =  $password = $this->container->get('security.password_encoder');
            $usuario->setPassword($helper->encodePassword($usuario, $usuario->getPassword()));
            $passwordSubmit = $formulario->get('cambiarPassword');
            if (($passwordSubmit instanceof SubmitButton) && $passwordSubmit->isClicked()) {
                $password = $this->container->get('security.password_encoder')
                    ->encodePassword($usuario, $formulario->get('newPassword')->get('first')->getData());
                $usuario->setPassword($password);
                $this->addFlash('success', 'Datos guardados correctamente y contraseña cambiada');
            }
            else {
                $this->addFlash('success', 'Datos guardados correctamente');
            }
            $em->flush();
            return new RedirectResponse(
                $this->generateUrl($this->isGranted('ROLE_ADMIN') ? 'usuarios_listar' : 'inicio')
            );
        }
        return $this->render('AppBundle:Usuario:modificar.html.twig', [
            'usuario' => $usuario,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/nuevo", name="usuario_nuevo_admin"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $usuario = new Usuario();
        $usuario->setEsActivo(true);
        $formulario = $this->createForm(new UsuarioType(), $usuario, array(
            'admin' => $this->isGranted('ROLE_ADMIN'),
            'coordinador' => $this->isGranted('ROLE_COORDINADOR'),
            'nuevo' => true
        ));
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $helper =  $password = $this->container->get('security.password_encoder');
            $usuario->setPassword($helper->encodePassword($usuario, $formulario->get('newPassword')->get('first')->getData()));
            $em->persist($usuario);
            $em->flush();
            $this->addFlash('success', 'Usuario creado correctamente');
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
     * @Security(expression="has_role('ROLE_ADMIN')")
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