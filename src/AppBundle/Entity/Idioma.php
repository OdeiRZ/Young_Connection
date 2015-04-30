<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $reading;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $writing;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $speaking;

    /**
     * @ORM\ManyToMany(targetEntity="Alumno", inversedBy="idiomas")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Alumno
     *
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
     * @param \AppBundle\Entity\Alumno $alumno
     * @return Idioma
     */
    public function setAlumno(\AppBundle\Entity\Alumno $alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return \AppBundle\Entity\Alumno 
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add alumno
     *
     * @param Alumno $alumno
     */
    public function addAlumno(Alumno $alumno)
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos->add($alumno);
        }
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
}
