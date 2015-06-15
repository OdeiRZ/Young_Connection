<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\UsuarioType;
use AppBundle\Utils\Aficiones;
use AppBundle\Utils\Mensajes;
use AppBundle\Utils\Notificaciones;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Ob\HighchartsBundle\Highcharts\Highchart;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function indexAction(Request $peticion)
    {
        $peticion->getSession()->set('mensajes_no_leidos', Mensajes::obtenerMensajesNoLeidos($this, $this->container,
                          $this->get('security.token_storage')->getToken()->getUser()));
        $peticion->getSession()->set('aficiones_no_validadas', Aficiones::obtenerAficionesNoValidadas($this, $this->container));
        $em = $this->getDoctrine()->getManager();
        $paises = $em->createQueryBuilder('u')
                     ->select('u.pais, count(u.pais) as total')
                     ->from('AppBundle:Usuario', 'u')
                     ->where('u.esAlumno = 1')
                     ->add('groupBy', 'u.pais')
                     ->orderBy('u.pais', 'ASC')
                     ->getQuery()
                     ->getResult();
        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Alumnos registrados por País');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
        $data = array();
        foreach($paises as $i => $pais) {
            $data[] = array($pais['pais'], intval($pais['total']));
        }
        $ob->series(array(array('type' => 'pie','name' => 'Total', 'data' => $data)));
        return $this->render('AppBundle:Default:inicio.html.twig', array(
            'chart' => $ob
        ));
    }

    /**
     * @Route("/entrar", name="usuario_entrar")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');
        return $this->render('AppBundle:Default:entrada.html.twig',
            [
                'ultimo_usuario' => $helper->getLastUsername(),
                'error' => $helper->getLastAuthenticationError()
            ]);
    }

    /**
     * @Route("/nuevo", name="usuario_nuevo"), methods={'GET', 'POST'}
     */
    public function nuevoAction(Request $peticion)
    {
        $usuario = new Usuario();
        $usuario
            ->setRuta("user.png")
            ->setEsActivo(true)
            ->setEsAdministrador(false)
            ->setEsCoordinador(false);
        $formulario = $this->createForm(new UsuarioType(), $usuario, array(
            'admin' => false,
            'coordinador' => false,
            'nuevo' => true
        ));
        $formulario->handleRequest($peticion);
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $helper = $password = $this->container->get('security.password_encoder');
            $usuario->setPassword($helper->encodePassword($usuario, $formulario->get('newPassword')->get('first')->getData()));
            $em->persist($usuario);
            $em->flush();
            $this->addFlash('success', 'Se ha enviado un correo a su email');
            Notificaciones::notificarRegistro($this, $this->get('mailer'), $this->container, $usuario);
            return new RedirectResponse(
                $this->generateUrl('inicio')
            );
        }
        return $this->render('AppBundle:Usuario:nuevo.html.twig', [
            'usuario' => $usuario,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/recordar", name="usuario_recordar"), methods={'GET', 'POST'}
     */
    public function recordarAction(Request $peticion)
    {
        $error = null;
        if ($peticion->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $usuarios = $em->getRepository('AppBundle:Usuario')
                           ->createQueryBuilder('p')
                           ->where('p.correoElectronico = :email')
                           ->setParameter('email', $peticion->get('_username'))
                           ->setMaxResults(1);
            $usuario = $em->createQuery($usuarios)
                          ->setParameter('email', $peticion->get('_username'))
                          ->getOneOrNullResult();
            if ($usuario != null) {
                $nuevaClave = "";
                $cadena = "abcdefghijklmnopqrstuvwxyz1234567890";
                for($i=0;$i<6;$i++) {
                    $nuevaClave .= substr($cadena, rand(0, strlen($cadena)),1);
                }
                $helper = $password = $this->container->get('security.password_encoder');
                $usuario->setPassword($helper->encodePassword($usuario, $nuevaClave));
                $em->persist($usuario);
                $em->flush();
                Notificaciones::notificarRegeneracion($this, $this->get('mailer'), $this->container, $usuario, $nuevaClave);
                $this->addFlash('success', 'Se ha enviado un correo a su email con una nueva Contraseña');
                return new RedirectResponse(
                    $this->generateUrl('inicio')
                );
            } else {
                $error = "El Correo no está registrado en el Sistema";
            }
        }
        return $this->render('AppBundle:Default:recordar.html.twig', [ 'error' => $error ]);
    }

}