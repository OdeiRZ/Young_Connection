<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Grupo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Alojamiento", mappedBy="grupos")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Alojamiento
     *
     */
    protected $alojamientos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alojamientos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add alojamientos
     *
     * @param \AppBundle\Entity\Alojamiento $alojamientos
     * @return Grupo
     */
    public function addAlojamiento(\AppBundle\Entity\Alojamiento $alojamientos)
    {
        $this->alojamientos[] = $alojamientos;

        return $this;
    }

    /**
     * Remove alojamientos
     *
     * @param \AppBundle\Entity\Alojamiento $alojamientos
     */
    public function removeAlojamiento(\AppBundle\Entity\Alojamiento $alojamientos)
    {
        $this->alojamientos->removeElement($alojamientos);
    }

    /**
     * Get alojamientos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlojamientos()
    {
        return $this->alojamientos;
    }

    /**
     *
     */
    public function __toString()
    {
        $aux = '';
        $alojamientos = $this->getAlojamientos();
        foreach($alojamientos as $alojamiento) {
            $aux .= $alojamiento . '<br/>';
        }
        return $aux;
    }
}
