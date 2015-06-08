<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Intercambio
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
     * @ORM\Column(type="date", nullable=false)
     *
     * @var \DateTime
     */
    protected $fechaInicio;

    /**
     * @ORM\Column(type="date", nullable=false)
     *
     * @var \DateTime
     */
    protected $fechaFin;

    /**
     * @ORM\OneToMany(targetEntity="Grupo", mappedBy="intercambio")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Grupo
     */
    protected $grupos;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $observaciones;

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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return Intercambio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     * @return Intercambio
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime 
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Intercambio
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add grupos
     *
     * @param \AppBundle\Entity\intercambio $grupos
     * @return Intercambio
     */
    public function addGrupo(\AppBundle\Entity\intercambio $grupos)
    {
        $this->grupos[] = $grupos;

        return $this;
    }

    /**
     * Remove grupos
     *
     * @param \AppBundle\Entity\intercambio $grupos
     */
    public function removeGrupo(\AppBundle\Entity\intercambio $grupos)
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
}
