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

class Notificaciones
{
    static public function notificarRegistro(Controller $controlador, \Swift_Mailer $mailer, Container $container, Usuario $usuario)
    {
        if ($usuario->getCorreoElectronico()) {
            $mensaje = $mailer->createMessage()
                ->setSubject($container->getParameter('prefijo_notificacion') . ' Bienvenido a la Plataforma ' . $usuario->getNombre() . ' ' . $usuario->getApellidos())
                ->setFrom($container->getParameter('remite_notificacion'))
                ->setTo([$usuario->getCorreoElectronico()])
                ->setBody( "Te damos la bienvenida al portal Young Connection.\n\n\nRecuerda que tu usuario sera tu correo electrónico: " . $usuario->getCorreoElectronico() . ".\n\n\nEsperamos que disfrutes de tu estancia.", 'text/plain');
            $mailer->send($mensaje);
        }
    }
    static public function notificarRegeneracion(Controller $controlador, \Swift_Mailer $mailer, Container $container, Usuario $usuario, $nuevaClave)
    {
        if ($usuario->getCorreoElectronico()) {
            $mensaje = $mailer->createMessage()
                ->setSubject($container->getParameter('prefijo_notificacion') . ' Regeneración de Contraseña')
                ->setFrom($container->getParameter('remite_notificacion'))
                ->setTo([$usuario->getCorreoElectronico()])
                ->setBody( "Se ha procesado correctamente su petición de Regeneración de Contraseña.\n\n\nTe Recordamos que tu usuario seguirá siendo tu correo electrónico: " . $usuario->getCorreoElectronico() . ".\nSe te ha asignado la nueva clave: " . $nuevaClave. "\n\n\nEsperamos que disfrutes de tu estancia.", 'text/plain');
            $mailer->send($mensaje);
        }
    }
}