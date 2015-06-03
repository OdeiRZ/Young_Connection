<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\FiltroApellidoType;
use AppBundle\Form\Type\UsuarioType;
use AppBundle\Utils\Aficiones;
use AppBundle\Utils\Mensajes;
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
    public function listarAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
            $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $apellidosDefecto = null;
        $form = $this->createForm(new FiltroApellidoType(), $apellidosDefecto)->handleRequest($peticion);
        $apellidos = ($form->isValid()) ? $_POST['filtroApellidos']['apellidos'] : null;
        $qb = $em->getRepository('AppBundle:Usuario')
            ->createQueryBuilder('u')
            ->orderBy('u.apellidos', 'DESC')
            ->addOrderBy('u.nombre', 'DESC');
        if ($apellidos) {
            $qb->where('u.apellidos LIKE :apellidos')
                ->orWhere('u.nombre LIKE :apellidos')
                ->setParameter('apellidos', '%'.$apellidos.'%');
        }
        $usuarios =  $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Usuario:listar.html.twig', [
            'formulario_apellidos' => $form->createView(),
            'usuarios' => $usuarios
        ]);
    }

    /**
     * @Route("/listar/alumnos", name="alumnos_listar")
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function listarAlumnosAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
            $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $apellidosDefecto = null;
        $form = $this->createForm(new FiltroApellidoType(), $apellidosDefecto)->handleRequest($peticion);
        $apellidos = ($form->isValid()) ? $_POST['filtroApellidos']['apellidos'] : null;
        $qb = $em->getRepository('AppBundle:Usuario')
            ->createQueryBuilder('u')
            ->orderBy('u.apellidos', 'DESC')
            ->addOrderBy('u.nombre', 'DESC')
            ->where('u.esAlumno = 1');
        if ($apellidos) {
            $qb->andWhere('u.apellidos LIKE :apellidos')
                ->orWhere('u.nombre LIKE :apellidos')
                ->setParameter('apellidos', '%'.$apellidos.'%');
        }
        $usuarios =  $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Usuario:listar.html.twig', [
            'formulario_apellidos' => $form->createView(),
            'usuarios' => $usuarios
        ]);
    }

    /**
     * @Route("/listar/coordinadores", name="coordinadores_listar")
     * @Security(expression="has_role('ROLE_ADMIN') or has_role('ROLE_COORDINADOR')")
     */
    public function listarCoordinadoresAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
            $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $apellidosDefecto = null;
        $form = $this->createForm(new FiltroApellidoType(), $apellidosDefecto)->handleRequest($peticion);
        $apellidos = ($form->isValid()) ? $_POST['filtroApellidos']['apellidos'] : null;
        $qb = $em->getRepository('AppBundle:Usuario')
            ->createQueryBuilder('u')
            ->orderBy('u.apellidos', 'DESC')
            ->addOrderBy('u.nombre', 'DESC')
            ->where('u.esCoordinador = 1');
        if ($apellidos) {
            $qb->andWhere('u.apellidos LIKE :apellidos')
                ->orWhere('u.nombre LIKE :apellidos')
                ->setParameter('apellidos', '%'.$apellidos.'%');
        }
        $usuarios =  $qb
            ->getQuery()
            ->getResult();
        return $this->render('AppBundle:Usuario:listar.html.twig', [
            'formulario_apellidos' => $form->createView(),
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
            'coordinador' => $this->isGranted('ROLE_COORDINADOR'),
            'alumno' => $this->isGranted('ROLE_ALUMNO')
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
     * @Security(expression="has_role('ROLE_ADMIN')")
     */
    public function nuevoAction(Request $peticion)
    {
        $usuario = new Usuario();
        $usuario->setEsActivo(true)
                ->setRuta("user.png");
        $formulario = $this->createForm(new UsuarioType(), $usuario, array(
            'admin' => $this->isGranted('ROLE_ADMIN'),
            'coordinador' => $this->isGranted('ROLE_COORDINADOR'),
            'alumno' => $this->isGranted('ROLE_ALUMNO'),
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