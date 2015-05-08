<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:inicio.html.twig');
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
}
