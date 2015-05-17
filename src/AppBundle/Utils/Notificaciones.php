<?php
/*
  Copyright (C) 2015: Luis Ramón López López

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see [http://www.gnu.org/licenses/].
*/

namespace AppBundle\Utils;

use AppBundle\Controller\DefaultController;
use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;

class Notificaciones {

    static public function notificarRegistro(Controller $controlador, \Swift_Mailer $mailer, Container $container, Usuario $usuario)
    {
        $enviado = false;
        if ($usuario->getCorreoElectronico()) {
            $mensaje = $mailer->createMessage()
                ->setSubject($container->getParameter('prefijo_notificacion') . ' Bienvenido a la Plataforma ' . $usuario->getNombre() . ' ' . $usuario->getApellidos())
                ->setFrom($container->getParameter('remite_notificacion'))
                ->setTo([$usuario->getCorreoElectronico()])
                ->setBody( "Te damos la bienvenida al portal Young Connection.\r\n\r\n\r\n
                            Recuerda que tu usuario sera tu correo electrónico: " . $usuario->getCorreoElectronico() . ".\r\n\r\n\r\n
                            Esperamos que disfrutes de tu estancia.", 'text/plain');
            $mailer->send($mensaje);
        }
        return $enviado;
    }
}