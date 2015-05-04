<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Familia
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
    protected $direccion;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $telefono;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $tieneMascota;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $detallesMascota;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $puedeMultiAlumno;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $puedeCompartirAlumno;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $detallesCompartirAlumno;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $tieneHabitacionExtra;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $observaciones;

    /**
     * @ORM\OneToMany(targetEntity="Alumno", mappedBy="familia")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Alumno
     */
    protected $alumnos;

    /**
     * @ORM\OneToMany(targetEntity="Miembro", mappedBy="familia", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Miembro
     */
    protected $miembros;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->miembros = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set direccion
     *
     * @param string $direccion
     * @return Familia
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Familia
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set tieneMascota
     *
     * @param boolean $tieneMascota
     * @return Familia
     */
    public function setTieneMascota($tieneMascota)
    {
        $this->tieneMascota = $tieneMascota;

        return $this;
    }

    /**
     * Get tieneMascota
     *
     * @return boolean 
     */
    public function getTieneMascota()
    {
        return $this->tieneMascota;
    }

    /**
     * Set detallesMascota
     *
     * @param string $detallesMascota
     * @return Familia
     */
    public function setDetallesMascota($detallesMascota)
    {
        $this->detallesMascota = $detallesMascota;

        return $this;
    }

    /**
     * Get detallesMascota
     *
     * @return string 
     */
    public function getDetallesMascota()
    {
        return $this->detallesMascota;
    }

    /**
     * Set puedeMultiAlumno
     *
     * @param boolean $puedeMultiAlumno
     * @return Familia
     */
    public function setPuedeMultiAlumno($puedeMultiAlumno)
    {
        $this->puedeMultiAlumno = $puedeMultiAlumno;

        return $this;
    }

    /**
     * Get puedeMultiAlumno
     *
     * @return boolean 
     */
    public function getPuedeMultiAlumno()
    {
        return $this->puedeMultiAlumno;
    }

    /**
     * Set puedeCompartirAlumno
     *
     * @param boolean $puedeCompartirAlumno
     * @return Familia
     */
    public function setPuedeCompartirAlumno($puedeCompartirAlumno)
    {
        $this->puedeCompartirAlumno = $puedeCompartirAlumno;

        return $this;
    }

    /**
     * Get puedeCompartirAlumno
     *
     * @return boolean 
     */
    public function getPuedeCompartirAlumno()
    {
        return $this->puedeCompartirAlumno;
    }

    /**
     * Set detallesCompartirAlumno
     *
     * @param string $detallesCompartirAlumno
     * @return Familia
     */
    public function setDetallesCompartirAlumno($detallesCompartirAlumno)
    {
        $this->detallesCompartirAlumno = $detallesCompartirAlumno;

        return $this;
    }

    /**
     * Get detallesCompartirAlumno
     *
     * @return string 
     */
    public function getDetallesCompartirAlumno()
    {
        return $this->detallesCompartirAlumno;
    }

    /**
     * Set tieneHabitacionExtra
     *
     * @param boolean $tieneHabitacionExtra
     * @return Familia
     */
    public function setTieneHabitacionExtra($tieneHabitacionExtra)
    {
        $this->tieneHabitacionExtra = $tieneHabitacionExtra;

        return $this;
    }

    /**
     * Get tieneHabitacionExtra
     *
     * @return boolean 
     */
    public function getTieneHabitacionExtra()
    {
        return $this->tieneHabitacionExtra;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Familia
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
     * Add alumnos
     *
     * @param \AppBundle\Entity\Alumno $alumnos
     * @return Familia
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
        return $this->getDireccion();
    }

    /**
     * Add miembros
     *
     * @param \AppBundle\Entity\Miembro $miembros
     */
    public function addMiembro(\AppBundle\Entity\Miembro $miembros)
    {
        //$miembro->setFamilia($this);
        //$this->miembros->setFamilia($miembro);
        $this->miembros[] = $miembros;
        $miembros->setFamilia($this);
    }

    /**
     * Get miembros
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMiembros()
    {
        return $this->miembros;
    }

    /**
     * Remove miembros
     *
     * @param \AppBundle\Entity\Miembro $miembros
     */
    public function removeMiembro(\AppBundle\Entity\Miembro $miembros)
    {
        $this->miembros->removeElement($miembros);
    }
}
