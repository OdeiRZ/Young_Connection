<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Idioma
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
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La descripción debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      minMessage = "El reading debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $reading;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      minMessage = "El writing debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $writing;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      minMessage = "El speaking debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $speaking;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="idiomas")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Usuario
     *
     */
    protected $alumno;

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
     * @return Idioma
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
     * Set reading
     *
     * @param string $reading
     * @return Idioma
     */
    public function setReading($reading)
    {
        $this->reading = $reading;

        return $this;
    }

    /**
     * Get reading
     *
     * @return string 
     */
    public function getReading()
    {
        return $this->reading;
    }

    /**
     * Set writing
     *
     * @param string $writing
     * @return Idioma
     */
    public function setWriting($writing)
    {
        $this->writing = $writing;

        return $this;
    }

    /**
     * Get writing
     *
     * @return string 
     */
    public function getWriting()
    {
        return $this->writing;
    }

    /**
     * Set speaking
     *
     * @param string $speaking
     * @return Idioma
     */
    public function setSpeaking($speaking)
    {
        $this->speaking = $speaking;

        return $this;
    }

    /**
     * Get speaking
     *
     * @return string 
     */
    public function getSpeaking()
    {
        return $this->speaking;
    }

    /**
     * Set alumno
     *
     * @param \AppBundle\Entity\Usuario $alumno
     * @return Idioma
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
}
