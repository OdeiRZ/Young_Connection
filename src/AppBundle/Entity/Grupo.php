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
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Usuario
     *
     */
    protected $coordinador;

    /**
     * @ORM\OneToMany(targetEntity="Alojamiento", mappedBy="grupo", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Alojamiento
     *
     */
    protected $alojamientos;

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
        $alojamientos->setGrupo($this);
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
     * Set coordinador
     *
     * @param \AppBundle\Entity\Usuario $coordinador
     * @return Grupo
     */
    public function setCoordinador(\AppBundle\Entity\Usuario $coordinador)
    {
        $this->coordinador = $coordinador;

        return $this;
    }

    /**
     * Get coordinador
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getCoordinador()
    {
        return $this->coordinador;
    }
}
