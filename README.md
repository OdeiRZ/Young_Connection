Young Connection 0.9
================================

Aplicación web para la gestión de la grupos de Intercambios de Alumnos entre centros educativos
(aún en modo beta, no está lista para producción). Desplegada en fase de pruebas unicamente en 
un equipo local.

Desde ella se podrán gestionar Intercambios de grupos de alumnos pertenecientes a diferentes centros 
además de llevar un control de las familias asociadas a los mismos, simplificando así las tareas de 
los coordinadores de grupos de intercambios de diferentes centros educativos.

Este proyecto utiliza [Symfony2] y otros muchos componentes que se instalan usando [Composer]

Para facilitar el desarrollo se proporciona un entorno [Vagrant] con todas las dependencias ya
instaladas.

## Requisitos

- PHP 5.3.7 o superior
- Servidor web Apache2 (podría funcionar con nginx, pero no se ha probado)
- Cualquier sistema gestor de bases de datos que funcione bajo Doctrine (p.ej. MySQL, MariaDB, PosgreSQL, SQLite, etc.)
- PHP [Composer]

## Instalación

- Ejecutar `composer install` desde la carpeta del proyecto.
- Configurar el sitio de Apache2 para que el `DocumentRoot` sea la carpeta `web/`
- Modificar el fichero `parameters.yml` con los datos de acceso al sistema gestor de bases de datos.
- Ejecutar `app/console assets:install` para completar la instalación de los recursos en la carpeta `web/`.
- Para crear la base de datos: `app/console doctrine:database:create`.
- Para crear las tablas: `app/console doctrine:schema:create`.
- Para insertar los datos iniciales: `app/console doctrine:fixtures:load`.

## Entorno de desarrollo

Para poder ejecutar la aplicación en un entorno de desarrollo basta con tener [Vagrant] instalado junto con [VirtualBox]
y ejecutar el comando `vagrant up`. La aplicación será accesible desde la dirección http://192.168.33.10/

## Licencia
Esta aplicación se ofrece bajo licencia [AGPL versión 3].

[Vagrant]: https://www.vagrantup.com/
[VirtualBox]: https://www.virtualbox.org
[Symfony2]: http://symfony.com/
[Composer]: http://getcomposer.org
[AGPL versión 3]: http://www.gnu.org/licenses/agpl.html