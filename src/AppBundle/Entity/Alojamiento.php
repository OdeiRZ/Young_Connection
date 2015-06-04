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
     * @ORM\ManyToMany(targetEntity="Familia")
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
     * @ORM\ManyToMany(targetEntity="Grupo", inversedBy="alojamientos")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Grupo
     *
     */
    protected $grupos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->familia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add familia
     *
     * @param \AppBundle\Entity\Familia $familia
     * @return Alojamiento
     */
    public function addFamilium(\AppBundle\Entity\Familia $familia)
    {
        $this->familia[] = $familia;

        return $this;
    }

    /**
     * Remove familia
     *
     * @param \AppBundle\Entity\Familia $familia
     */
    public function removeFamilium(\AppBundle\Entity\Familia $familia)
    {
        $this->familia->removeElement($familia);
    }

    /**
     * Get familia
     *
     * @return \Doctrine\Common\Collections\Collection 
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
     * Add grupos
     *
     * @param \AppBundle\Entity\Grupo $grupos
     * @return Alojamiento
     */
    public function addGrupo(\AppBundle\Entity\Grupo $grupos)
    {
        $this->grupos[] = $grupos;

        return $this;
    }

    /**
     * Remove grupos
     *
     * @param \AppBundle\Entity\Grupo $grupos
     */
    public function removeGrupo(\AppBundle\Entity\Grupo $grupos)
    {
        $this->grupos->removeElement($grupos);
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getAlumno() . ' ' .
               $this->getFamilia();
    }
}
