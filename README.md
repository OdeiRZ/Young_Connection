# Young Connection

Aplicación web en Symfony 2 para gestionar intercambios de alumnos entre centros educativos: grupos, familias de acogida, alojamientos y comunicación entre los participantes.

## Características

- Modelo de datos completo con Doctrine ORM: `Intercambio`, `Grupo`, `Centro`, `Curso`, `Usuario`, `Familia`, `Alojamiento`, `Miembro`, `Aficion`, `Idioma` y `Mensaje`.
- CRUD completo (listar, crear, consultar, modificar) para usuarios, centros, cursos, grupos, familias, aficiones e intercambios, con formularios Symfony (`Form/Type`) y filtros de búsqueda dedicados (por apellido, país, curso, fechas, coordinador, etc.).
- Gestión de familias de acogida y su alojamiento asociado a cada alumno de intercambio.
- Sistema de mensajería interna entre usuarios de la plataforma (`MensajeController`, entidad `Mensaje`).
- Notificaciones por correo electrónico (Swiftmailer) al registrar un usuario y al regenerar su contraseña (`Utils/Notificaciones.php`).
- Generación de informes en PDF (`Utils/InformePDF.php`, extendiendo TCPDF) para exportar listados como el de un intercambio (`Intercambio/imprimir.html.twig`).
- Datos de ejemplo (fixtures de Doctrine) para usuarios y aficiones, listos para cargar tras instalar.
- Interfaz con tablas interactivas (DataTables), efectos con TweenMax y traducciones al español (`Resources/translations`).
- Entorno de desarrollo reproducible con Vagrant.

**Nota:** el propio autor describe el proyecto como en fase beta, probado solo en entornos locales.

## Tecnologías

- PHP >= 5.4 / Symfony 2.6
- Doctrine ORM + Doctrine Fixtures Bundle
- Twig
- Swiftmailer (notificaciones por email)
- TCPDF (`whiteoctober/tcpdf-bundle`) para informes en PDF
- Highcharts (`ob/highcharts-bundle`) para gráficas
- jQuery DataTables, TweenMax (frontend)
- Vagrant + VirtualBox (entorno de desarrollo)

## Instalación / Cómo ejecutarlo

1. Instala las dependencias con Composer:
   ```
   composer install
   ```
2. Configura el sitio de Apache para que el `DocumentRoot` sea la carpeta `web/`.
3. Copia `app/config/parameters.yml.dist` a `app/config/parameters.yml` y configura la conexión a base de datos.
4. Instala los recursos públicos:
   ```
   php app/console assets:install
   ```
5. Crea la base de datos y las tablas:
   ```
   php app/console doctrine:database:create
   php app/console doctrine:schema:create
   ```
6. Carga los datos iniciales de ejemplo:
   ```
   php app/console doctrine:fixtures:load
   ```

**Con Vagrant:**
1. Instala [Vagrant](https://www.vagrantup.com/) y [VirtualBox](https://www.virtualbox.org).
2. Desde la raíz del proyecto ejecuta `vagrant up` y accede a `http://192.168.33.10/`.

Requiere PHP 5.3.7 o superior (recomendado >= 5.4).

## Seguridad

Actualizado `symfony/symfony` a la v2.6.13 para corregir CVE-2015-2308 y CVE-2015-4050. Corregido además un control de acceso roto (comprobaciones de rol ausentes en varias acciones) y añadida protección CSRF en las operaciones de borrado, y sustituida la contraseña predecible del usuario admin de las fixtures de ejemplo.

## Licencia

AGPL versión 3 (ver archivo [LICENSE](LICENSE)).
