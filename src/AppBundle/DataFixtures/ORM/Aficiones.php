<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Aficion;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Aficiones extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $aficiones = ['Animales','Cine / TV','Comer / Beber','Deportes','Juegos / VideoJuegos','Libros / Cultura','Moda','Música','Viajar'];
        foreach($aficiones as $i=>$aficion) {
            ${'aficion' . $i} = new Aficion();
            ${'aficion' . $i}->setDescripcion($aficion)
                    ->setValidada(true);
            $manager->persist(${'aficion' . $i});
        }
        $manager->flush();
    }
}