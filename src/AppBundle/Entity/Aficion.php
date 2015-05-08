<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Aficion
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
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $validada;

    /**
     * @ORM\ManyToMany(targetEntity="Alumno", mappedBy="aficiones")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Alumno
     *
     */
    protected $alumnos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Aficion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set validada
     *
     * @param boolean $validada
     * @return Aficion
     */
    public function setValidada($validada)
    {
        $this->validada = $validada;

        return $this;
    }

    /**
     * Get validada
     *
     * @return boolean 
     */
    public function getValidada()
    {
        return $this->validada;
    }

    /**
     * Add alumnos
     *
     * @param \AppBundle\Entity\Alumno $alumnos
     * @return Aficion
     */
    public function addAlumno(\AppBundle\Entity\Alumno $alumnos)
    {
        $this->alumnos[] = $alumnos;

        return $this;
    }

    /**
     * Remove alumnos
     *
     * @param \AppBundle\Entity\Alumno $alumnos
     */
    public function removeAlumno(\AppBundle\Entity\Alumno $alumnos)
    {
        $this->alumnos->removeElement($alumnos);
    }

    /**
     * Get alumnos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlumnos()
    {
        return $this->alumnos;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getDescripcion();
    }
}
