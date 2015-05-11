<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Curso
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
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $familia;

    /**
     * @ORM\ManyToOne(targetEntity="Centro", inversedBy="cursos")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Centro
     *
     */
    protected $centro;

    /**
     * @ORM\OneToMany(targetEntity="Alumno", mappedBy="curso")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Alumno
     */
    protected $alumnos;

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
     * @return Curso
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
     * Set familia
     *
     * @param string $familia
     * @return Curso
     */
    public function setFamilia($familia)
    {
        $this->familia = $familia;

        return $this;
    }

    /**
     * Get familia
     *
     * @return string 
     */
    public function getFamilia()
    {
        return $this->familia;
    }

    /**
     * Set centro
     *
     * @param \AppBundle\Entity\Centro $centro
     * @return Curso
     */
    public function setCentro(\AppBundle\Entity\Centro $centro)
    {
        $this->centro = $centro;

        return $this;
    }

    /**
     * Get centro
     *
     * @return \AppBundle\Entity\Centro 
     */
    public function getCentro()
    {
        return $this->centro;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add alumnos
     *
     * @param \AppBundle\Entity\Alumno $alumnos
     * @return Curso
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
