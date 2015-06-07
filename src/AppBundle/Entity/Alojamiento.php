<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Alojamiento
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
     * @ORM\ManyToOne(targetEntity="Familia")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Familia
     *
     */
    protected $familia;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Usuario
     */
    protected $alumno;

    /**
     * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="alojamientos")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Grupo
     *
     */
    protected $grupo;

    /**
     *
     */
    public function __toString()
    {
        return $this->getAlumno() . ' ' .
               $this->getFamilia();
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
     * Set familia
     *
     * @param \AppBundle\Entity\Familia $familia
     * @return Alojamiento
     */
    public function setFamilia(\AppBundle\Entity\Familia $familia)
    {
        $this->familia = $familia;

        return $this;
    }

    /**
     * Get familia
     *
     * @return \AppBundle\Entity\Familia 
     */
    public function getFamilia()
    {
        return $this->familia;
    }

    /**
     * Set alumno
     *
     * @param \AppBundle\Entity\Usuario $alumno
     * @return Alojamiento
     */
    public function setAlumno(\AppBundle\Entity\Usuario $alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set grupo
     *
     * @param \AppBundle\Entity\Grupo $grupo
     */
    public function setGrupo(\AppBundle\Entity\Grupo $grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * Get grupo
     *
     * @return \AppBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
