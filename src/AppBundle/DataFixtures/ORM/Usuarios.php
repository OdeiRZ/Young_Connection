<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Usuarios extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 100;
    }

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');
        $usuario = new Usuario();
        $usuario->setCorreoElectronico('admin@admin.com')
            ->setPassword($encoder->encodePassword($usuario, 'admin@admin.com'))
            ->setNombre('Admin')
            ->setApellidos('Uno')
            ->setFechaNacimiento(new \DateTime('1980-05-01'))
            ->setSexo('M')
            ->setTelefono('666666666')
            ->setPais('España')
            ->setEsActivo(true)
            ->setEsAdministrador(true)
            ->setEsCoordinador(false)
            ->setEsAlumno(false)
            ->setEstaDisponible(false);
        $manager->persist($usuario);
        $manager->flush();
    }
}