<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La descripción debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $validada;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="aficiones")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Usuario
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
     * @param \AppBundle\Entity\Usuario $alumnos
     * @return Aficion
     */
    public function addAlumno(\AppBundle\Entity\Usuario $alumnos)
    {
        $this->alumnos[] = $alumnos;

        return $this;
    }

    /**
     * Remove alumnos
     *
     * @param \AppBundle\Entity\Usuario $alumnos
     */
    public function removeAlumno(\AppBundle\Entity\Usuario $alumnos)
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
